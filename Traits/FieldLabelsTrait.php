<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

use Exception;

trait FieldLabelsTrait
{

    public static function fieldLabels()
    {
        $return = [];

        foreach(static::defaultProperty('validationRules', []) as $field => $rules)
        {
            if (is_array($rules) && array_key_exists('label', $rules))
            {
                $return[$field] = static::lang($rules['label']);
            }
        }

        foreach(static::defaultProperty('fieldLabels', []) as $field => $label)
        {
            $return[$field] = static::lang($label);
        }

        return $return;
    }    

    public static function fieldLabel($field)
    {
        $validationRules = static::defaultProperty('validationRules', []);

        if (array_key_exists($field, $validationRules))
        {
            if (is_array($validationRules[$field]) && array_key_exists('label', $validationRules[$field]))
            {
                return static::lang($validationRules[$field]['label']);
            }
        }

        $labels = static::defaultProperty('fieldLabels', []);

        if (array_key_exists($field, $labels))
        {
            return static::lang($labels[$field]);
        }

        return $field;
    }

    public function getFieldLabel($field)
    {
        $validationRules = $this->validationsRules;

        if (array_key_exists($field, $validationRules))
        {
            if (is_array($validationRules[$field]) && array_key_exists('label', $validationRules[$field]))
            {
                return static::lang($validationRules[$field]['label']);
            }
        }

        if (property_exists($this, 'fieldLabels'))
        {
            $fieldLabels = $this->fieldLabals;

            if (array_key_exists($field, $fieldLabels))
            {
                return static::lang($fieldLabels[$field]);
            }
        }

        return $field;
    }

    public function getFieldLabels()
    {
        $return = [];

        foreach($this->validationRules as $field => $rules)
        {
            if (is_array($rules) && array_key_exists('label', $rules))
            {
                $return[$field] = static::lang($rules['label']);
            }
        }

        foreach($this->fieldLabels as $field => $label)
        {
            $return[$field] = static::lang($label);
        }

        return $return;
    }

}