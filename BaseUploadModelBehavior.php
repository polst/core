<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

abstract class BaseUploadModelBehavior extends ModelBehavior implements ModelBehaviorInterface
{

    public static $oldFiles = [];

    public static function getUploadedFile(string $name)
    {
        $request = service('Request');

        $file = $request->getFile($name);

        if (!$file || !$file->getName())
        {
            return null;
        }

        if (!$file->isValid())
        {
            $error = $file->getErrorString() . '(' . $file->getError() . ')';

            throw new Exception('File ' . $name . ' error:  ' . $error);
        }

        if ($file->hasMoved())
        {
            throw new Exception('File has moved: ' . $name);
        }

        return $file;
    }

    public static function moveUploadedFile($file, $path, $filename)
    {
        if (!$file)
        {
            return;
        }

        if ($filename === null)
        {
            $filename = $file->getRandomName();
        }

        if (!is_dir($path))
        {
            throw new Exception('Path not found: ' . $path);
        }

        $moved = $file->move($path, $filename); // $path = $file->store('head_img/', 'user_name.jpg');

        if (!$moved)
        {
            throw new Exception('Move file error: ' . $name);
        }

        return $filename;
    }

    public static function beforeSave(array $params) : array
    {
        $modelClass = $params['modelClass'];

        $inputName = $params['inputName'];

        $path = rtrim($params['path'], '/');

        $field = $params['field'];

        $file = static::getUploadedFile($inputName);

        if ($file)
        {
            static::$oldFiles[$field] = ($params['data'])->$field;

            ($params['data'])->$field = $file->getRandomName();

            $filename = static::moveUploadedFile($file, $path, ($params['data'])->$field);

            if (array_key_exists('square', $params))
            {
                if ($params['square'])
                {
                    ImageHelper::square($path . '/' . ($params['data'])->$field);
                }
            }
        }

        return $params;
    }

    public static function beforeDelete(array $params)
    {
        $id = $params['id'];

        $path = rtrim($params['path'], '/');

        $modelClass = $params['modelClass'];

        $field = $params['field'];

        $models = $modelClass::factory()->find($id);

        if (count($models) > 1)
        {
            throw new Exception('Deleting multiple objects is not supported.');
        }

        foreach($models as $model)
        {
            if ($model->$field)
            {
                static::$oldFiles[$field] = $model->$field;
            }
        }
    }

    public static function afterDelete(array $params)
    {
        static::deleteFile($params);
    }

    public static function afterSave(array $params) : array
    {
        if ($params['result'])
        {
            static::deleteFile($params);
        }

        return $params;
    }

    public static function deleteFile(array $params)
    {
        $field = $params['field'];

        if (!empty(static::$oldFiles[$field]))
        {
            $filename = rtrim($params['path'], '/') . '/' . static::$oldFiles[$field];

            if (is_file($filename))
            {
                unlink($filename);
            }

            unset(static::$oldFiles[$field]);
        }
    }    

}