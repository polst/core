<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

trait FieldLabelTrait
{

    public function fieldLabel($field, $default = null)
    {
        $labels = $this->getFieldLabels();

        if (array_key_exists($field, $labels))
        {
            return $labels[$field];
        }

        return $default;
    }

}
