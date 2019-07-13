<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Exception;

trait ModelLabelsTrait
{

    public static function getLabels()
    {
        $return = static::getDefaultProperty('labels', []);

        foreach($return as $field => $label)
        {
            $return[$field] = static::t($label);
        }

        return $return;
    }

    public static function label($field, $default = null)
    {
        $labels = static::getLabels();

        if (array_key_exists($field, $labels))
        {
            return $labels[$field];
        }

        if ($default === null)
        {
            return $field;
        }

        return $default;
    }

}