<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use CodeIgniter\Config\BaseConfig;

abstract class BaseDatabaseConfig extends BaseConfig
{

    public function __construct()
    {
        parent::__construct();

        $values = DatabaseConfigModel::formValues(static::class);

        foreach ($values as $property => $value)
        {
            if (property_exists($this, $property))
            {
                $this->{$property} = $value;
            }
        }
    }

}