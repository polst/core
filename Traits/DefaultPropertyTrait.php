<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

use ReflectionClass;

trait DefaultPropertyTrait
{

	public static function defaultProperty($name, $default = null)
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