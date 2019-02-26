<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

trait ModelFieldLabelsTrait
{

    public static function getTranslateFieldLabels() : bool
    {
        return static::$translateFieldLabels;
    }

    public static function getFieldLabels() : array
    {
        $return = static::$fieldLabels;

        foreach($return as $field => $label)
        {
            $return[$field] = static::translateFieldLabel($field, $label);
        }

        return $return;
    }

    public static function fieldLabel($field, $default = null) : string
    {
        $labels = static::getFieldLabels();

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

    public static function translateFieldLabel(string $field, string $label, array $params = []) : string
    {
        if (!static::getTranslateFieldLabels())
        {
            return $label;
        }

        return static::t($label, $params);
    }

}