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

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function fieldLabel($field, $default = null)
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
