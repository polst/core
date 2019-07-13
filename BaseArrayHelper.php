<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

abstract class BaseArrayHelper
{

    public static function getValue($array, $value, $default = null)
    {
        if (is_object($array))
        {
            if (property_exists($array, $value))
            {
                return $array->$value;
            }

            return $default;
        }

        if (array_key_exists($value, $array))
        {
            return $array[$value];
        }

        return $default;
    }

}