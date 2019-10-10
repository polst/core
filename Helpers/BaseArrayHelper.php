<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

abstract class BaseArrayHelper
{

    public static function setValue($array, $key, $value)
    {
        if (is_array($array))
        {
            $array[$key] = $value;
        }
        else
        {
            $array->$key = $value;
        }

        return $array;
    }

    public static function getValue($array, $value, $default = null)
    {
        if (is_array($array))
        {
            if (array_key_exists($value, $array))
            {
                return $array[$value];
            }            
        }
        else
        {
            $return = $array->$value;

            if ($return !== null)
            {
                return $return;
            }
        }

        return $default;
    }

}