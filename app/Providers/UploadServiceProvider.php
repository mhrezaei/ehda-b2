<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    private static $defaultUserType = 'default';
    private static $defaultSection = 'default';
    private static $preloader = false;

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

    public static function getTypeRule($fileType, $configName)
    {
        return self::followUpConfig(self::generateConfigPath($fileType) . ".$configName");
    }

    public static function getSectionRule($section, $configName)
    {
        return self::followUpConfig(self::generateConfigPath($section, true) . ".$configName");
    }

    public static function showUploader($fileTypeString, $data = [])
    {
        if (self::isActive($fileTypeString)) {
            $fileType = last(self::translateFileTypeString($fileTypeString));
            return view('uploader.box', compact('fileType') + $data);
        }
    }

    public static function setDefaultUserType($userType)
    {
        self::$defaultUserType = $userType;
    }

    public static function setDefaultSection($section)
    {
        self::$defaultSection = $section;
    }

    private static function translateFileTypeString($fileTypeString)
    {
        $fileTypeParts = array_reverse(explodeNotEmpty('.', $fileTypeString));
        if (!isset($fileTypeParts[1])) {
            $fileTypeParts[1] = self::$defaultSection;
        }
        if (!isset($fileTypeParts[2])) {
            $fileTypeParts[2] = self::$defaultUserType;
        }

        $fileTypeParts = array_reverse($fileTypeParts);

        return $fileTypeParts;
    }

    private static function generateConfigPath($configPath, $section = false)
    {
        $parts = self::translateFileTypeString($configPath);
        if (!$section) {
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
        $levels = explodeNotEmpty('.', $configPath);
        if ($checked < count($levels)) {
            $currentIndex = $checked + 1;
            $checkedPart = array_slice($levels, -$currentIndex);
            $uncheckedPart = array_slice($levels, 0, -$currentIndex);
            $uncheckedPart[count($uncheckedPart) - 1] = 'default';
            $newConfigPath = implode('.', array_merge($uncheckedPart, $checkedPart));
            if (Config::has($newConfigPath)) {
                return Config::get($newConfigPath);
            } else {
                return self::followUpConfig($configPath, $currentIndex);
            }
        }
    }
}
