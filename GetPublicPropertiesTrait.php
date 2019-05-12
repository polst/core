<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use ReflectionObject;
use ReflectionProperty;

trait GetPublicPropertiesTrait
{

    public function getPublicProperties(array $return = [])
    {
        $reflectionProperties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach($reflectionProperties as $reflectionProperty)
        {
            $key = $reflectionProperty->name;

            $return[$key] = $this->$key; 
        }

        return $return;
    }

}