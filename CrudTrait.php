<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Config\Services;
use Exception;

trait CrudTrait
{

	protected function _getProperty($name, $default = null)
	{
		if (property_exists($this, $name))
		{
			return $this->$name;
		}

		if ($default !== null)
		{
			return $default;
		}

		throw new Exception('Property "' . $name . '" not defined.');
	}

    protected function getSearchModelClass($default = null)
    {
        return $this->_getProperty('searchModelClass', $default);
    }

	protected function getModelClass()
	{
		return $this->_getProperty('modelClass');
	}

	protected function getParentField()
	{
		return $this->_getProperty('parentField', false);
	}	

	protected function getIndexView()
	{
		return $this->_getProperty('indexView', 'index');
	}

	protected function getCreateView()
	{
		return $this->_getProperty('createView', 'create');
	}

	protected function getUpdateView()
	{
		return $this->_getProperty('updateView', 'update');
	}

	protected function getPerPage()
	{
		return $this->_getProperty('perPage', false);
	}

	protected function getOrderBy()
	{
		return $this->_getProperty('orderBy', false);
	}

	protected function getReturnUrl()
	{
		return $this->_getProperty('returnUrl');
	}

	protected function redirectBack($returnUrl)
	{
		$url = $this->request->getGet('returnUrl');

		if (!$url)
		{
			$url = $returnUrl;
		}

		helper(['url']);

		$returnUrl = site_url($url);

    	return Services::response()->redirect($returnUrl);
	}

	protected function fillEntity($entity, array $values)
	{
		if (is_array($entity))
		{
			foreach($values as $key => $value)
			{
				$entity[$key] = $value;
			}
		}
		else
		{
			$entity->fill($values);
		}

		return $entity;
	}

	protected function save($model)
	{
		$query = $this->createQuery();

		$query->save($model);

		$errors = $query->errors();

		return $errors;
	}

	public function update()
	{
		$errors = [];

		$model = $this->find();

		$post = $this->request->getPost();

		if ($post)
		{
			$this->fillEntity($model, $post);

			$errors = $this->save($model);

			if (!$errors)
			{
				return $this->redirectBack($this->getReturnUrl());
			}
		}

		$parentId = null;

		$parentField = $this->getParentField();

		if ($parentField)
		{
			$parentId = $model->{$parentField};
		}

		return $this->renderUpdate([
			'errors' => $errors,
			'model' => $model,
			'parentId' => $parentId
		]);
	}

	protected function createEntity($parentId = false)
	{
		$params = [];

		$parentField = $this->getParentField();

		if ($parentField && $parentId)
		{
			$params[$parentField] = $parentId;
		}

		$modelClass = $this->getModelClass();		

		return $modelClass::createEntity($params);
	}

	public function create()
	{
		$errors = [];

        $parentField = $this->getParentField();

        $parentId = null;

        if ($parentField)
        {
            $parentId = $this->request->getGet('parentId');

            if (!$parentId)
            {
                throw new PageNotFoundException;
            }
        }
		
		$model = $this->createEntity($parentId);
		
		$post = $this->request->getPost();

		if ($post)
		{
			$this->fillEntity($model, $post);

			$errors = $this->save($model);

			if (!$errors)
			{
				return $this->redirectBack($this->returnUrl);
			}
		}

		return $this->renderCreate([
			'model' => $model,
			'errors' => $errors,
			'parentId' => $parentId
		]);
	}

	public function delete()
	{
		$query = $this->createQuery();

		$model = $this->find();

		if ($this->request->getPost())
		{
            $primaryKey = $model->getPrimaryKey();

			if (!$query->delete($primaryKey))
			{
				throw new Exception('Record is not deleted.');
			}
		}
        else
        {
            throw new PageNotFoundException;
        }

		return $this->redirectBack($this->returnUrl);
	}

	protected function createQuery()
	{
		$modelClass = $this->getModelClass();

		$query = new $modelClass;

		return $query;
	}

	protected function find()
	{
        $id = $this->request->getGet('id');

		if (!$id)
		{
            throw new PageNotFoundException;
		}

		$query = $this->createQuery();

		$model = $query->find($id);

		if (!$model)
		{
			throw new PageNotFoundException;
		}

		return $model;
	}

	protected function beforeFind($query)
	{
	}

	public function index()
	{
		$query = $this->createQuery();

        $searchModelClass = $this->getSearchModelClass(false);

        if ($searchModelClass)
        {
            $searchModel = $searchModelClass::factory();

            $search = $searchModel->createEntity();

            $search->fill($this->request->getGet());

            $searchModel::applyToQuery($search, $query);
        }
        else
        {
            $searchModel = null;

            $search = null;
        }

        $parentField = $this->getParentField();

        $parentId = null;

        if ($parentField)
        {
            $parentId = $this->request->getGet('parentId');

            if (!$parentId)
            {
                throw new PageNotFoundException;
            }

            $query->where($parentField, $parentId);
        }

		if ($this->getOrderBy())
		{
			$query->orderBy($this->getOrderBy());
		}

		$this->beforeFind($query);

		$perPage = $this->getPerPage();

		if ($perPage)
		{
			$elements = $query->paginate($perPage);
		}
		else
		{
			$elements = $query->findAll();
		} 

		return $this->renderIndex([
			'elements' => $elements,
			'pager' => $query->pager,
			'parentId' => $parentId,
            'searchModel' => $searchModel,
            'search' => $search
		]);
	}

    protected function renderIndex(array $params = [])
    {
        return $this->render($this->getIndexView(), $params);
    }

    protected function renderCreate(array $params = [])
    {
        return $this->render($this->getCreateView(), $params);
    }

    protected function renderUpdate(array $params = [])
    {
        return $this->render($this->getUpdateView(), $params);
    }    

}