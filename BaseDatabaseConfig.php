<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Config\BaseConfig;

abstract class DatabaseConfig extends BaseConfig
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