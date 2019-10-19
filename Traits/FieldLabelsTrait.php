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

    public static function fieldLabel($field)
    {
        $validationRules = static::getDefaultProperty('validationRules', []);

        if (array_key_exists($field, $validationRules))
        {
            if (is_array($validationsRules[$field]) && array_key_exists('label', $validationRules[$field]))
            {
                return static::lang($validationRules[$field]['label']);
            }
        }

        $labels = static::getDefaultProperty('fieldLabels', []);

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
            if (is_array($validationsRules[$field]) && array_key_exists('label', $validationRules[$field]))
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

}