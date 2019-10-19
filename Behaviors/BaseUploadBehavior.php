<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Behaviors;

use Exception;
use Closure;
use BasicApp\Core\ModelBehavior;
use BasicApp\Interfaces\ModelBehaviorInterface;
use BasicApp\Helpers\ImageHelper;
use BasicApp\Helpers\ArrayHelper;

abstract class BaseUploadBehavior extends ModelBehavior implements ModelBehaviorInterface
{

    public $square = false;

    public $input;

    public $field;

    public $path;

    protected $_old = [];

    protected $_deleted = [];

    public function getPath()
    {
        return rtrim($this->path, '/');
    }

    public function getUploadedFile(string $name)
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
            throw new Exception('File already moved: ' . $name);
        }

        return $file;
    }

    public function moveUploadedFile($file, $path, $filename)
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

    public function beforeSave(array $params) : array
    {
        $path = $this->getPath();

        $field = $this->field;

        $file = $this->getUploadedFile($this->input);

        $data = $params['data'];

        if ($file)
        {
            $this->_old = ArrayHelper::getValue($data, $field);

            $value = $file->getRandomName();

            $data = ArrayHelper::setValue($data, $field, $value);

            $filename = $this->moveUploadedFile($file, $path, $value);

            if ($this->square)
            {
                ImageHelper::square($path . '/' . $value);
            }
        }

        $params['data'] = $data;

        return $params;
    }

    public function afterSave(array $params) : array
    {
        if ($params['result'])
        {
            $this->deleteOldFile();
        }

        return $params;
    }

    public function deleteOldFile()
    {
        if ($this->_old)
        {
            $this->deleteFile($this->_old);

            $this->_old = null;
        }
    }

    public function deleteFile($name)
    {
        $filename = $this->getPath() . '/' . $name;

        if (is_file($filename))
        {
            unlink($filename);
        }
    }

    public function beforeDelete(array $params)
    {
        $id = $params['id'];

        $modelClass = get_class($this->owner);
  
        $rows = $modelClass::factory()->find($id);

        $field = $this->field;

        foreach($rows as $row)
        {
            if (is_array($row))
            {
                $this->_deleted[] = $row[$field];
            }
            else
            {
                $this->_deleted[] = $row->$field;
            }
        }
    }

    public function afterDelete(array $params)
    {
        foreach($this->_deleted as $key => $value)
        {
            $this->deleteFile($value);

            unset($this->_deleted[$key]);
        }
    }

}