<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseModel extends \CodeIgniter\Model
{

	protected static $fieldLabels = [];

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function getReturnType()
	{
		return $this->returnType;
	}

	public function getFieldLabels()
	{
		return static::$fieldLabels;
	}

    public static function fieldLabel($field, $default = null)
    {
        $labels = static::getFieldLabels();

        if (array_key_exists($field, $labels))
        {
            return $labels[$field];
        }

        return $default;
    }

	public function errors(bool $forceDB = false)
	{
		$errors = parent::errors($forceDB);

		if ($errors)
		{
			$labels = $this->getFieldLabels();

			foreach($errors as $key => $value)
			{
				$errors[$key] = strtr($errors[$key], $labels);
			}	
		}
		
		return $errors;
	}

}
