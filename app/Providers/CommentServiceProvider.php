<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    private static $defaultRules = ['text' => 'required|persian:60'];

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
     * Translate standard "fields" value of a "commenting" post
     * @param $fieldsString string
     * @return array
     */
    public static function translateFields($fieldsString)
    {
        /**
         * translation rules
         * 1. separate fields description with comma (,)
         * 2. start each field description with its "name" (ex: "subject,first_name")
         * 3. if you want that field to has a label add "-label" to the field description (ex: "subject-label")
         * 4. if you want that field to has a column size (bootstrap columns) add ":size" (ex: "subject:6")
         * 5. put no "next-line" in fields string
         */

        if ($fieldsString and is_string($fieldsString)) {
            $fields = explodeNotEmpty(',', $fieldsString);
            foreach ($fields as $fieldIndex => $fieldValue) {
                unset($fields[$fieldIndex]);
                $fieldValue = trim($fieldValue);

                if (str_contains($fieldValue, '*')) {
                    $fieldValue = str_replace('*', '', $fieldValue);
                    $tmpField['required'] = true;
                } else {
                    $tmpField['required'] = false;
                }

                if (str_contains($fieldValue, '-label')) {
                    $fieldValue = str_replace('-label', '', $fieldValue);
                    $tmpField['label'] = true;
                } else {

                    $tmpField['label'] = false;
                }

                if (str_contains($fieldValue, ':')) {
                    $fieldValueParts = explodeNotEmpty(':', $fieldValue);
                    $fieldValue = $fieldValueParts[0];
                    $tmpField['size'] = $fieldValueParts[1];
                } else {
                    $tmpField['size'] = '';
                }
                $fields[$fieldValue] = $tmpField;
            }
            return $fields;
        }

        return [];
    }


    /**
     * Translate standard "rules" value of a "commenting" post
     * @param string $rulesString
     * @param boolean $detailed If "false" this function will return rules of any field in a single item (request standard rule)
     * @return array
     */
    public static function translateRules($rulesString, $detailed = true)
    {
        /**
         * translation rules
         * 1. separate fields rules with comma (,)
         * 2. start each field description with its "name" (ex: "subject,first_name")
         * 3. after name of the field, put ":" and enter rules in the pipeline separated format
         * 4. each rule should be one of laravel standard rules
         * 5. put no "next-line" in rules string
         */

        if ($rulesString and is_string($rulesString)) {
            $rulesString = str_replace("\n", '', $rulesString);
            $rules = explodeNotEmpty(',', $rulesString);

            foreach ($rules as $index => $rule) {
                $rule = trim($rule);
                unset($rules[$index]);

                $parts = explodeNotEmpty('=>', $rule);

                if ($parts and is_array($parts) and (count($parts) == 2)) {
                    $fieldName = trim($parts[0]);
                    if ($detailed) {
                        $fieldRules = explodeNotEmpty('|', $parts[1]);
                        if (count($fieldRules)) {
                            $rules[$fieldName] = $fieldRules;
                        }
                    }
                }
            }

            return $rules;
        }

        return [];
    }


    public static function getPostCommentRules($post, $detailed = true)
    {
        $post = PostsServiceProvider::smartFindPost($post);
        if ($post->exists) {
            $post->spreadMeta();
            $rulesString = $post->rules;
            if (strtolower($rulesString) == 'no') {
                return [];
            } else {
                return self::translateRules($rulesString, $detailed);
            }
        }
        return self::$defaultRules;
    }

    public static function getDefaultCommentRules()
    {
        return self::$defaultRules;
    }
}
