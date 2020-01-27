<?php
/**
 * @author Basic App Dev Team <dev@basic-app.con>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

use Exception;
use BasicApp\Helpers\ArrayHelper;

trait FieldLabelsTrait
{

    public function getFieldLabel(string $field) : string
    {
        return ArrayHelper::getValue($this->getFieldLabels(), $field, $field);
    }

    public function getFieldLabels() : array
    {
        $return = [];

        if (property_exists($this, 'fieldLabels'))
        {
            foreach($this->fieldLabels as $field => $label)
            {
                $return[$field] = $this->getLanguageLine($label);
            }
        }        

        foreach($this->validationRules as $field => $rules)
        {
            if (is_array($rules) && array_key_exists('label', $rules))
            {
                $return[$field] = $this->getLanguageLine($rules['label']);
            }
        }

        return $return;
    }

}