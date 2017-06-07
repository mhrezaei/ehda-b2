<?php

namespace App\Providers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\File\File;

class UploadServiceProvider extends ServiceProvider
{
    private static $defaultLevels = [
        'default', // default userType
        'default', // default section
    ];
    private static $currentLevels = [
        'default',
        'default',
    ];
    private static $preloaderShown = false;
    private static $defaultJsConfigs = [];
    private static $defaultAcceptableLevelsNumber = 2; // number of level that can be changed to default value
    private static $rootUploadDir = 'uploads'; // Root Directory
    private static $randomNameLength = 16; // Length of Random Name to Be Generated for Uploading Files

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Checks if uploading of a file type is activated or not
     * @param $fileType
     * @param string $userType
     * @return mixed
     */
    public static function isActive($fileType, $userType = 'client')
    {
        return self::followUpConfig(self::generateConfigPath($fileType) . ".status");
    }

    /**
     * Get a Config Value For a File Type from Upload Configs
     * @param string $fileType
     * @param string $configName
     * @return mixed
     */
    public static function getTypeRule($fileType, $configName)
    {
        return self::followUpConfig(self::generateConfigPath($fileType) . ".$configName");
    }

    /**
     * Get a Config Value For a Section from Upload Configs
     * @param string $section
     * @param string $configName
     * @return mixed
     */
    public static function getSectionRule($section, $configName)
    {
        return self::followUpConfig(self::generateConfigPath($section, true) . ".$configName");
    }

    /**
     * Return a View Containing DropZone Uploader Element and Related JavaScript Codes
     * @param string $fileTypeString
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function dropzoneUploader($fileTypeString, $data = [])
    {
        if (self::isActive($fileTypeString)) {

            // preloader view will be added to view only in generating first uploader
            if (!self::$preloaderShown) {
                $preloaderView = view('uploader.preloader');
                self::$preloaderShown = true;
            }

            $fileTypeStringParts = self::translateFileTypeString($fileTypeString);
            $fileType = last($fileTypeStringParts);
            $uploadIdentifier = implode('.', $fileTypeStringParts);
            return view('uploader.box', compact('fileType', 'preloaderView', 'uploadIdentifier') + $data);
        }
    }

    /**
     * Set User Type to Read Upload Settings From Configs
     * @param string $userType
     * @return void
     */
    public static function setUserType($userType)
    {
        self::$currentLevels[0] = $userType;
    }

    /**
     * Set Section to Read Upload Settings From Configs
     * @param string $section
     * @return void
     */
    public static function setSection($section)
    {
        self::$currentLevels[1] = $section;
    }

    /**
     * Set Some Configs to Be Set to All Uploader Elements
     * @param array|string $first If this is string it will be assumed as config key
     * @param null|mixed $second If $first is string this will be assumed as config value
     */
    public static function setDefaultJsConfigs($first, $second = null)
    {
        if (is_array($first)) {
            self::$defaultJsConfigs = array_merge(self::$defaultJsConfigs, $first);
        } else {
            self::$defaultJsConfigs = array_merge(self::$defaultJsConfigs, [$first => $second]);
        }
    }

    /**
     * Get Current Default JS Configs
     * @param string $key Key Of Requested Config (If empty all JS Configs will be returned)
     * @return array|mixed
     */
    public static function getDefaultJsConfigs($key = '')
    {
        if ($key) {
            return self::$defaultJsConfigs[$key];
        }

        return self::$defaultJsConfigs;
    }


    public static function validateFile($request)
    {
        $file = $request->file;
        $typeString = $request->uploadIdentifier;
        $sessionName = $request->groupName;

        $acceptedExtensions = self::getTypeRule($typeString, 'acceptedExtensions');
        if (!$acceptedExtensions or !is_array($acceptedExtensions) or !count($acceptedExtensions)) {
            $acceptedExtensions = [];
        }

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:' . implode(',', $acceptedExtensions) .
                '|max:' . (self::getTypeRule($typeString, 'maxFileSize') * 1024)
        ]);

        if (!$validator->fails() and
            self::validateFileNumbers($sessionName, $typeString)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $sessionName
     * @param string $typeString
     */
    public static function validateFileNumbers($sessionName, $typeString)
    {
        if (!session()->has($sessionName) or
            count(array_filter(session()->get($sessionName), function ($item){
                return $item['done'];
            })) < self::getTypeRule($typeString, 'maxFiles')
        ) {
            return true;
        }
        return false;
    }

    /**
     * Upload File to Specified Directory
     * @param UploadedFile $file
     * @param string $uploadDir Directory for Destination File
     * @return File;
     */
    public static function uploadFile($file, $uploadDir)
    {
        $newName = str_random(self::$randomNameLength) . '.' . $file->getClientOriginalExtension();
        $finalUploadDir = self::$rootUploadDir . DIRECTORY_SEPARATOR . $uploadDir;
        return $file->move($finalUploadDir, $newName);
    }

    /**
     * Remove
     * @param File $file
     * @return bool
     */
    public static function removeFile($file)
    {
        return \Illuminate\Support\Facades\File::delete($file->getPathname());
    }

    /**
     * Convert $fileTypeString to a meaning full array
     * @param string $fileTypeString
     * @return array
     */
    private static function translateFileTypeString($fileTypeString)
    {
        $fileTypeParts = array_reverse(explodeNotEmpty('.', $fileTypeString));
        if (!isset($fileTypeParts[1])) {
            $fileTypeParts[1] = self::$currentLevels[1];
        }
        if (!isset($fileTypeParts[2])) {
            $fileTypeParts[2] = self::$currentLevels[0];
        }

        $fileTypeParts = array_reverse($fileTypeParts);

        return $fileTypeParts;
    }

    /**
     * Convert $sectionString to a meaning full array
     * @param string $sectionString
     * @return array
     */
    private static function translateSectionString($sectionString)
    {
        $sectionParts = array_reverse(explodeNotEmpty('.', $sectionString));
        if (!isset($sectionParts[0])) {
            $sectionParts[0] = self::$currentLevels[1];
        }
        if (!isset($sectionParts[1])) {
            $sectionParts[1] = self::$currentLevels[0];
        }

        $sectionParts = array_reverse($sectionParts);

        return $sectionParts;
    }

    /**
     * Generate Config Path String
     * @param string $configPath
     * @param bool $section <ul><li>TRUE: Path is For a Section</li><li>FALSE: Path is For a File Type</li></ul>
     * @return string This function will return a dot separated string to use in accessing a config
     */
    private static function generateConfigPath($configPath, $section = false)
    {
        $parts = self::translateFileTypeString($configPath);
        if ($section) {
            $parts = self::translateSectionString($configPath);
        } else {
            $parts = self::translateFileTypeString($configPath);
            array_splice($parts, 2, 0, 'fileTypes');
        }

        return 'upload.' . implode('.', $parts);
    }

    /**
     * Follow up a config and search specified or default available value
     * @param string $configPath Config Path (Dot Separated)
     * @param int $checked Number of Checked Levels
     * @return mixed Found Config
     * @throws null if config not found
     */
    private static function followUpConfig($configPath, $checked = 0)
    {
        if (self::findExistedPath($configPath)) {
            return Config::get(self::findExistedPath($configPath));
        }
    }

    /**
     * Searches for closest existed path
     * @param string $configPath
     * @param int $step Searching Step (Starts from 0)
     * @return string
     */
    private static function findExistedPath($configPath, $step = 0)
    {
        $levels = explodeNotEmpty('.', $configPath);
        $mostPossibleLevel = pow(2, self::$defaultAcceptableLevelsNumber) - 1;

        if ($step <= $mostPossibleLevel) {
            $keysToBeChanged = self::getReplacementKeys($step, self::$defaultAcceptableLevelsNumber);
            $changed = false;

            foreach ($keysToBeChanged as $key) {
                if ($levels[$key + 1] != self::$defaultLevels[$key]) {
                    $levels[$key + 1] = self::$defaultLevels[$key];
                    $changed = true;
                }
            }

            if ($changed) {
                $newConfigPath = implode('.', $levels);
                if (Config::has($newConfigPath)) {
                    return $newConfigPath;
                }
            }

            return self::findExistedPath($configPath, $step + 1);
        }
    }

    /**
     * Returns keys that should be replaced by default value in every step
     * @param int $stepNumber
     * @param int $replacementRange Number of Fields That Can Be Replaced by the Default Value
     * @return array
     */
    private static function getReplacementKeys($stepNumber, $replacementRange)
    {
        $binary = str_pad(decbin($stepNumber), $replacementRange, 0, STR_PAD_LEFT);
        $binaryArr = str_split($binary);
        $filteredBinaryArr = array_filter($binaryArr, function ($var) {
            return $var;
        });
        $replacementKeys = array_keys($filteredBinaryArr);

        return $replacementKeys;
    }
}
