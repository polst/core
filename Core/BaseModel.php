<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Exception;

use BasicApp\Traits\FactoryTrait;
use BasicApp\Traits\GetDefaultPropertyTrait;
use BasicApp\Traits\BehaviorsTrait;
use BasicApp\Traits\ModelTranslationsTrait;
use BasicApp\Traits\ModelLabelsTrait;
use BasicApp\Traits\ModelEntityTrait;

abstract class BaseModel extends \CodeIgniter\Model
{

    use FactoryTrait;

    use GetDefaultPropertyTrait;

    use BehaviorsTrait;

    use ModelTranslationsTrait;

    use ModelLabelsTrait;

    use ModelEntityTrait;

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

    public function getValidation()
    {
        return $this->validation;
    }

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

        if ($result && $this->insertID)
        {
            $data = static::entitySetField($data, $this->primaryKey, $this->insertID);
        }

        $params = $this->trigger('afterSave', ['data' => $data, 'result' => $result]);

        $result = $params['result'];

        return $result;
    }

    /**
     * Fix "You must use the "set" method to update an entry." error when you save model without changes.
     * ToDo: Need to remove this later...    
     */
    public static function classToArray($data, $primaryKey = null, string $dateFormat = 'datetime', bool $onlyChanged = false) : array 
    {

        return parent::classToArray($data, $primaryKey, $dateFormat, $onlyChanged);
    }

}