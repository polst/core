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

    use ModelTranslationsTrait;

    use ModelFieldLabelsTrait;

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

	protected static $fieldLabels = [];

    protected static $translateFieldLabels = false;

    protected static $translationsCategory;

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

            $config = $class::beforeSave($config);

            $params['data'] = $config['data'];
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

            $config = $class::afterSave($config);

            $params['data'] = $config['data'];

            $params['result'] = $config['result'];
        }

        return $params;
    }

    protected function beforeValidate(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::beforeValidate($config);

            $params['data'] = $config['data'];

            $params['validationRules'] = $config['validationRules'];
        }

        return $params;
    }

    protected function afterValidate(array $params) : array
    {
        foreach($this->getBehaviors() as $config)
        {
            $class = $config['class'];

            unset($config['class']);

            foreach($params as $key => $value)
            {
                $config[$key] = $value;
            }

            $config = $class::afterValidate($config);

            $params['data'] = $config['data'];

            $params['result'] = $config['result'];
        }

        return $params;
    }    

    public function validate($data) : bool
    {
        // save validation rules

        $validationRules = $this->validationRules;

        // prepare validation rules and data

        $params = $this->trigger('beforeValidate', [
            'validationRules' => $validationRules,
            'data' => $data
        ]);

        $this->validationRules = $params['validationRules'];

        $data = $params['data'];

        // validate

        $result = parent::validate($data);

        // call validate behavior

        $params = $this->trigger('afterValidate', [
            'data' => $data,
            'result' => $result
        ]);

        // restore validation rules

        $this->validationRules = $validationRules;

        // return result

        return $params['result'];
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