<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

use Exception;

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

	public static function getFieldLabels()
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

	public static function getEntity(array $where, bool $create = false, array $params = [])
	{
		$class = static::class;

		$model = new $class;

		$row = $model->where($where)->first();

		if ($row)
		{
			return $row;
		}

		if (! $create)
		{
			return null;
		}

		$builder = $model->builder();

		foreach ($where as $key => $value)
		{
			$params[$key] = $value;
		}

		$success = $builder->replace($params);

		if (!$success)
		{
			throw new Exception('Replace failed.');
		}

		$id = $model->db->insertID();

		if (!$id)
		{
			throw new Exception('Created entity ID is empty.');
		}

		$model = new $class;

		$row = $model->where($model->primaryKey, $id)->first();

		if (!$row)
		{
			throw new Exception('Created entity not found.');
		}

		return $row;
	}

}
