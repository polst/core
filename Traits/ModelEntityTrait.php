<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Traits;

use Exception;

trait ModelEntityTrait
{

    public static function entitySetField($entity, string $col, string $value)
    {
        if (is_array($entity))
        {
            $entity[$col] = $value;
        }
        else
        {
            $entity->$col = $value;
        }

        return $entity;
    }

    public static function entityPrimaryKey($entity)
    {
        $primaryKey = static::getDefaultProperty('primaryKey');

        $returnType = static::getDefaultProperty('returnType');

        if (is_array($entity))
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

    public static function getEntity(array $where, bool $create = false, array $params = [], bool $update = false)
    {
        $class = static::class;

        $model = new $class;

        $row = $model->where($where)->first();

        if ($row)
        {
            if ($update)
            {
                $updated = false;

                foreach($params as $key => $value)
                {
                    if ($row->$key != $value)
                    {
                        $row->$key = $value;
                    
                        $updated = true;
                    }
                }

                if ($updated)
                {
                    $id = $model->entityPrimaryKey($row);

                    if (!$id)
                    {
                        throw new Exception('Primary key is not defined.');
                    }
             
                    $model->protect(false);

                    $result = $model->update($id, $params);

                    $model->protect(true);
                }
            }

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

}