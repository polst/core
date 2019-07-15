<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Traits;

use ReflectionObject;
use ReflectionProperty;

trait GetPublicPropertiesTrait
{

    public function getPublicProperties(array $return = [])
    {
        $reflectionProperties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach($reflectionProperties as $reflectionProperty)
        {
            if ($reflectionProperty->isStatic())
            {
                continue;
            }

            $key = $reflectionProperty->name;

            $return[$key] = $this->$key; 
        }

        return $return;
    }

}