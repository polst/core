<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use ReflectionClass;

trait GetDefaultPropertyTrait
{

	public static function getDefaultProperty($name, $default = null)
	{
        static $_properties = [];

        $class = get_called_class();

        if (!array_key_exists($class, $_properties))
        {
            $mirror = new ReflectionClass($class);

            $_properties[$class] = $mirror->getDefaultProperties();
        }

		if (array_key_exists($name, $_properties[$class]))
		{
			return $_properties[$class][$name];
		}

		return $default;
	}

}