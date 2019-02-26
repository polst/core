<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

trait EntityFieldLabelsTrait
{

    public function fieldLabel($field, $default = null) : string
    {
        $modelClass = $this->getModelClass();

        return $modelClass::fieldLabel($field, $default);
    }

    public function getFieldLabels()
    {
        $modelClass = $this->getModelClass();

        return $model::getFieldLabels();
    }

}