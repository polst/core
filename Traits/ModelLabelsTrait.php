<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Traits;

use Exception;

trait ModelLabelsTrait
{

    //protected static $_labels;

    /*

    public function getFieldLabel($field)
    {
        if (property_exists($this, 'fieldLabels'))
        {
            if (array_key_exists($field, $this->labels))
            {
                return static::t($this->labels[$field]);
            }
        }

        if (array_key_exists($field, $this->validationRules))
        {
            if (is_array($this->validationRules[$field]))
            {
                if (array_key_exists('label', $this->validationRules[$field]['label']))
                {
                    return static::t($this->validationRules['label']);
                }
            }
        }

        return $field;
    }

    */

    public static function getLabels()
    {
        $labels = [];

        $labels = static::getDefaultProperty('labels', []);

        foreach($labels as $field => $label)
        {
            $labels[$field] = static::t($label);
        }

        $validationRules = static::getDefaultProperty('validationRules', []);

        foreach($validationRules as $field => $rules)
        {
            if (is_array($rules) && array_key_exists('label', $rules))
            {
                $labels[$field] = static::t($rules['label']);
            }
        }
    
        return $labels;
    }

    public static function fieldLabel($field, $default = null)
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

    public static function label($field, $default = null)
    {
        return static::fieldLabel($field, $default);
    }

}