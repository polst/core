<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
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