<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Exception;
use ReflectionObject;
use ReflectionProperty;
use BasicApp\Traits\FactoryTrait;
use BasicApp\Traits\GetDefaultPropertyTrait;
use BasicApp\Traits\GetPublicPropertiesTrait;
use BasicApp\Traits\EntityHasOneTrait;
use BasicApp\Traits\EntityHasManyTrait;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use FactoryTrait;
    use GetDefaultPropertyTrait;
    use GetPublicPropertiesTrait;
    use EntityHasOneTrait;
    use EntityHasManyTrait;
    
    protected $modelClass;

    public function __construct()
    {
        parent::__construct();

        if (!$this->modelClass)
        {
            throw new Exception('Property "modelClass" not defined.');
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

        $return = $model->save($this->getPublicProperties());

        if (!$validate)
        {
            $model->protect(true);
        }
    
        return $return;
    }

}