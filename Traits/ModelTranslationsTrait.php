<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Traits;

trait ModelTranslationsTrait
{

    public static function t(string $value, array $params = [], bool $resetCache = false) : string
    {
        static $translations = [];

        $class = get_called_class();

        if ($resetCache || !array_key_exists($class, $translations))
        {
            $translations[$class] = $class::getDefaultProperty('translations', null);
        }

        if (!$translations[$class])
        {
            return strtr($value, $params);
        }

        return t($translations[$class], $value, $params);
    }

}