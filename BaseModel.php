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

    protected $afterFind = ['afterFind']; 

    protected $beforeInsert = ['beforeInsert'];

    protected $afterInsert = ['afterInsert'];

    protected $beforeUpdate = ['beforeUpdate'];

    protected $afterUpdate = ['afterUpdate'];

    protected $beforeDelete = ['beforeDelete'];

    protected $afterDelete = ['afterDelete'];

    protected $beforeSave = ['beforeSave'];

    protected $afterSave = ['afterSave'];

    protected $prepareValidationRules = ['prepareValidationRules'];

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

        if ($default === null)
        {
        	return $field;
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

	public static function createEntity(array $params = [])
	{
		if ($this->returnType === 'array')
		{
			return $params;
		}

		$returnType = $this->returnType;

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

    public function getBehaviors()
    {
        return [];
    }

    public function afterFind(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::afterFind($config);

            $params['data'] = $config['data'];
        }

        return $params;    
    }

    public function beforeInsert(array $params) : array
    {
        $params = $this->beforeSave($params);

        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::beforeInsert($config);

            $params['data'] = $config['data'];
        }

        return $params;
    }

    public function afterInsert(array $params)
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::afterInsert($config);
        }
    }

    public function beforeUpdate(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::beforeUpdate($config);

            $params['data'] = $config['data'];
        }

        return $params;
    }

    public function afterUpdate(array $params)
    {
        $this->afterSave($params);

        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::afterUpdate($config);
        }
    }

    public function beforeDelete(array $params)
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::beforeDelete($config);
        }
    }

    public function afterDelete(array $params)
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::afterDelete($config);
        }
    }

    protected function beforeSave(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::beforeSave($config);
        }

        return $params;
    }

    protected function afterSave(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $class::afterSave($config);
        }

        return $params;
    }

    public function prepareValidationRules(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::prepareValidationRules($config);
        }

        return $params;
    }

    public function validate($data) : bool
    {
        // save validation rules

        $validationRules = $this->validationRules;

        // prepare validation rules

        $params = $this->trigger('prepareValidationRules', ['data' => $data, 'rules' => $validationRules]);

        $this->validationRules = $params['rules'];

        // validate

        $result = parent::validate($data);

        // restore validation rules

        $this->validationRules = $validationRules;

        // return result

        return $result;
    }

    public function save($data)
    {
        $params = $this->trigger('beforeSave', ['data' => $data]);

        $data = $params['data'];

        $result = parent::save($data);

        $params = $this->trigger('afterSave', ['data' => $data, 'result' => $result]);

        $result = $params['result'];

        return $result;
    }    

}