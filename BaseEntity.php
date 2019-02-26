<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use FactoryTrait;

    use EntityFieldLabelsTrait;

    protected $modelClass;

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function getPrimaryKey()
    {
        $modelClass = $this->getModelClass();

        $model = $modelClass::factory();

        $primaryKey = $model->getPrimaryKey();        

        if (property_exists($this, $primaryKey))
        {
            return $this->$primaryKey;
        }

        return null;
    }

}