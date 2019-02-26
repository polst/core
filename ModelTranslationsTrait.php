<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

trait ModelTranslationsTrait
{

    public static function getTranslationsCategory() : string
    {
        $return = static::$translationsCategory;
   
        if (!$return)
        {
            $return = get_called_class();
        }

        return $return;
    }

    public static function t(string $value, array $params = []) : string
    {
        return t(static::getTranslationsCategory(), $value, $params);
    }

}