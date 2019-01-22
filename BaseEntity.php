<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use FieldLabelTrait;

    protected $modelClass;

    protected $_fieldLabels;

    public function getFieldLabels()
    {
        if ($this->_fieldLabels === null)
        {
            $modelClass = $this->getModelClass();

            $model = new $modelClass;

            $this->_fieldLabels = $model->getFieldLabels();
        }

        return $this->_fieldLabels;
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

}
