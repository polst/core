<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use CodeIgniter\Config\BaseConfig;
use Exception;

abstract class BaseDatabaseConfig extends BaseConfig
{

    protected $modelClass;

    public function __construct()
    {
        parent::__construct();

        $modelClass = $this->modelClass;

        $values = $modelClass::formValues(static::class);

        foreach ($values as $property => $value)
        {
            if (property_exists($this, $property))
            {
                $this->{$property} = $value;
            }
        }
        
        if (!$this->modelClass)
        {
            throw new Exception('Property "modelClass" not defined.');
        }
    }

    public function label($field, $default = null)
    {
        $modelClass = $this->modelClass;

        return $modelClass::label($field, $default);
    }    

}