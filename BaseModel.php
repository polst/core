<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

abstract class BaseModel extends \CodeIgniter\Model
{

    use FactoryTrait;

    use GetDefaultPropertyTrait;

    use BehaviorsTrait;

    use ModelTranslationsTrait;

    use ModelLabelsTrait;

    protected $afterFind = ['afterFind']; 

    protected $beforeInsert = ['beforeInsert'];

    protected $afterInsert = ['afterInsert'];

    protected $beforeUpdate = ['beforeUpdate'];

    protected $afterUpdate = ['afterUpdate'];

    protected $beforeDelete = ['beforeDelete'];

    protected $afterDelete = ['afterDelete'];

    protected $beforeSave = ['beforeSave'];

    protected $afterSave = ['afterSave'];

    protected $beforeValidate = ['beforeValidate'];

    protected $afterValidate = ['afterValidate'];

    protected $labels = [];

    protected $translations = null;

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function getReturnType()
	{
		return $this->returnType;
	}

	public function errors(bool $forceDB = false)
	{
		$errors = parent::errors($forceDB);

		if ($errors)
		{
			$labels = $this->getLabels();

			foreach($errors as $key => $value)
			{
				$errors[$key] = strtr($errors[$key], $labels);
			}	
		}
		
		return $errors;
	}

    public static function entityPrimaryKey($entity)
    {
        $primaryKey = static::getDefaultProperty('primaryKey');

        $returnType = static::getDefaultProperty('returnType');

        if ($returnType == 'array')
        {
            if (array_key_exists($primaryKey, $entity))
            {
                return $entity[$primaryKey];
            }

            return null;
        }

        if (property_exists($entity, $primaryKey))
        {
            return $entity->$primaryKey;
        }

        return null;
    }

	public static function createEntity(array $params = [])
	{
        $model = static::factory();

		if ($model->returnType === 'array')
		{
			return $params;
		}

        // create object

		$returnType = $model->returnType;

		$model = new $returnType;

		foreach($params as $key => $value)
		{
			$model->$key = $value;
		}

		return $model;
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

		if (!$create)
		{
			return null;
		}

		foreach ($where as $key => $value)
		{
			$params[$key] = $value;
		}

		$model->protect(false);

		$result = $model->insert($params);

		$model->protect(true);

		if (!$result)
		{
			// nothing to do
		}

		$row = $model->where($where)->first();

		if (!$row)
		{
			throw new Exception('Entity not found.');
		}

		return $row;
	}

    public function afterFind(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->afterFind($params);
        }

        return $params;    
    }

    public function beforeInsert(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->beforeInsert($params);
        }

        return $params;
    }

    public function afterInsert(array $params)
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $this->as($behavior)->afterInsert($params);
        }
    }

    public function beforeUpdate(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->beforeUpdate($params);
        }

        return $params;
    }

    public function afterUpdate(array $params)
    {
        $this->afterSave($params);

        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $this->as($behavior)->afterUpdate($params);
        }
    }

    public function beforeDelete(array $params)
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $this->as($behavior)->beforeDelete($params);
        }
    }

    public function afterDelete(array $params)
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $this->as($behavior)->afterDelete($params);
        }
    }

    protected function beforeSave(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->beforeSave($params);
        }

        return $params;
    }

    protected function afterSave(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->afterSave($params);
        }

        return $params;
    }

    protected function beforeValidate(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->beforeValidate($params);
        }

        return $params;
    }

    protected function afterValidate(array $params) : array
    {
        foreach(array_keys($this->behaviors()) as $behavior)
        {
            $params = $this->as($behavior)->afterValidate($params);
        }

        return $params;
    }    

    public function validate($data) : bool
    {
        // save validation rules

        $validationRules = $this->validationRules;

        // prepare validation rules and data

        $params = $this->trigger('beforeValidate', ['validationRules' => $validationRules, 'data' => $data]);

        $this->validationRules = $params['validationRules'];

        $data = $params['data'];

        // validate

        $result = parent::validate($data);

        // call validate behavior

        $params = $this->trigger('afterValidate', ['data' => $data, 'result' => $result]);

        // restore validation rules

        $this->validationRules = $validationRules;

        // return result

        return $params['result'];
    }

    public function save($data) : bool
    {
        $params = $this->trigger('beforeSave', ['data' => $data]);

        $data = $params['data'];

        $result = parent::save($data);

        $params = $this->trigger('afterSave', ['data' => $data, 'result' => $result]);

        $result = $params['result'];

        return $result;
    }

}