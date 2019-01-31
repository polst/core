<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    protected $modelClass;

    protected $_fieldLabels;

    public function fieldLabel($field, $default = null)
    {
        $labels = $this->getFieldLabels();

        if (array_key_exists($field, $labels))
        {
            return $labels[$field];
        }

        return $default;
    }

    public function getFieldLabels()
    {
        if ($this->_fieldLabels === null)
        {
            $modelClass = $this->getModelClass();

            $model = new $modelClass;

            $this->_fieldLabels = $model::getFieldLabels();
        }

        return $this->_fieldLabels;
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

}
