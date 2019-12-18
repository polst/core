<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Behaviors;

use BasicApp\Core\ModelBehavior;
use BasicApp\Interfaces\ModelBehaviorInterface;

abstract class BaseUniqueBehavior extends ModelBehavior implements ModelBehaviorInterface
{

    public $fields = [];

    public $message;

    public function getDefaultMessage()
    {
        return lang('Validation.is_unique');
    }

    public function afterValidate(array $params) : array
    {
        if (!$params['result'])
        {
            return $params; // don't validate record with errors
        }

        $data = $params['data'];

        foreach($this->fields as $field => $columns)
        {
            if (!is_array($columns))
            {
                $field = $columns;

                $columns = [$columns];
            }

            if (empty($data[$field]))
            {
                continue; // don't validate empty value
            }

            $value = $data[$field];

            $result = $this->checkUnique($data, $columns);

            if (!$result)
            {
                $params['result'] = 0;

                $error = $this->message;

                if (!$error)
                {
                    $error = $this->getDefaultMessage();
                }

                $owner = $this->owner;

                $error = strtr($error, ['{field}' => $owner::fieldLabel($field)]);

                $this->owner->getValidation()->setError($field, $error);
            }
        }

        $params['data'] = $data;

        return $params;
    }

    public function checkUnique(array $data, array $columns)
    {
        $where = [];

        foreach($columns as $col)
        {
            $value = $data[$col];

            if (!$value)
            {
                $where[$col] = null;
            }
            else
            {
                $where[$col] = $value;
            }
        }

        $modelClass = get_class($this->owner);

        $query = new $modelClass;

        $query->where($where);

        $id = $modelClass::entityPrimaryKey($data);

        if ($id)
        {
            $query->where($this->owner->primaryKey . ' !=', $id);
        }

        if (!$query->first())
        {
            return true;
        }

        return false;
    }

}