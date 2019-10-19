<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;
use ReflectionObject;
use ReflectionProperty;
use BasicApp\Traits\FactoryTrait;
use BasicApp\Traits\DefaultPropertyTrait;
use BasicApp\Traits\HasOneTrait;
use BasicApp\Traits\HasManyTrait;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use FactoryTrait;
    use DefaultPropertyTrait;
    use HasOneTrait;
    use HasManyTrait;
    
    protected $modelClass;

    public function __construct()
    {
        parent::__construct();

        if (!$this->modelClass)
        {
            throw new Exception('Property "modelClass" is required.');
        }
    }

    public function getPrimaryKey()
    {
        $modelClass = $this->modelClass;

        return $modelClass::entityPrimaryKey($this);
    }

    public function getFieldlabel($field, $default = null)
    {
        $modelClass = $this->modelClass;

        return $modelClass::fieldLabel($field, $default);
    }

    public function delete()
    {
        $modelClass = $this->modelClass;

        $model = new $modelClass;

        return $model->delete($this->getPrimaryKey());
    }

    public function save(bool $validate = true)
    {
        $modelClass = $this->modelClass;

        $model = new $modelClass;

        if (!$validate)
        {
            $model->protect(false);
        }

        $return = $model->save($this);

        if (!$validate)
        {
            $model->protect(true);
        }
    
        return $return;
    }

}