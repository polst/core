<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

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