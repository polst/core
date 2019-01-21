<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseModel extends \CodeIgniter\Model
{

	public static function fieldLabels()
	{
		return [];
	}

	public function getFieldLabel($field, $default = null)
	{
		$labels = static::fieldLabels();

		if (array_key_exists($field, $labels))
		{
			return $labels[$field];
		}

		return $default;
	}

	public function errors(bool $forceDB = false)
	{
		$errors = parent::errors($forceDB);

		$labels = static::fieldLabels();

		foreach($errors as $key => $value)
		{
			$errors[$key] = strtr($errors[$key], $labels);
		}

		return $errors;
	}

}
