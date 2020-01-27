<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

abstract class BaseArrayHelper
{

    public static function setValue($data, $key, $value)
    {
        if (is_array($data))
        {
            $data[$key] = $value;
        }
        else
        {
            $data->$key = $value;
        }

        return $data;
    }

    public static function getValue($data, $value, $default = null)
    {
        if (is_array($data) && !empty($data[$value]) && ($data[$value] !== null))
        {
            return $data[$value];
        }
        elseif(!empty($data->$value) && ($data->$value !== null))
        {
            return $data->$value;
        }

        return $default;
    }

}