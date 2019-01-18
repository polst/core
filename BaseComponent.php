<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseComponent
{

	public static function factory($params = [])
	{
		$class = get_called_class();

		$return = new $class;

		foreach($params as $key => $value)
		{
			$return->$key = $value;
		}

		return $return;
	}

}
