<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use FactoryTrait;

    use GetDefaultPropertyTrait;

    protected $modelClass;

    public function __construct()
    {
        parent::__construct();

        if (!$this->modelClass)
        {
            throw new Exception('Property "modelClass" is not defined.');
        }
    }

    public function getPrimaryKey()
    {
        $modelClass = $this->modelClass;

        return $modelClass::entityPrimaryKey($this);
    }

    public function label($field, $default = null)
    {
        $modelClass = $this->modelClass;

        return $modelClass::label($field, $default);
    }

    public function getLabels()
    {
        $modelClass = $this->modelClass;

        return $model::getLabels();
    }

}