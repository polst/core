<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

trait LangTrait
{

    public static function lang(string $value, array $params = [], bool $resetCache = false) : string
    {
        static $translations = [];

        $class = get_called_class();

        if ($resetCache || !array_key_exists($class, $translations))
        {
            $translations[$class] = $class::getDefaultProperty('langCategory', null);
        }

        if (!$translations[$class])
        {
            return strtr($value, $params);
        }

        return t($translations[$class], $value, $params);
    }

}