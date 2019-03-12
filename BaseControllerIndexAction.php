<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseControllerIndexAction extends ControllerAction
{

    protected $modelClass;

    protected $searchModelClass;

    protected $orderBy;

    protected $perPage = 25;

    protected $beforeFind;

    public function run(array $params = [])
    {
        $query = $this->createModel($this->modelClass);

        $searchModelClass = $this->searchModelClass;

        if ($searchModelClass)
        {
            $searchModel = $this->createSearchModel($this->searchModelClass);

            $search = $searchModel->createEntity();

            $search->fill($controller->request->getGet());

            $searchModel::applyToQuery($search, $query);
        }
        else
        {
            $searchModel = null;

            $search = null;
        }

        $parentField = $this->parentField;

        $parentId = null;

        if ($parentField)
        {
            $parentId = $controller->request->getGet($this->parentFieldIndex);

            if (!$parentId)
            {
                throw new PageNotFoundException;
            }

            $query->where($parentField, $parentId);
        }

        if ($this->orderBy)
        {
            $query->orderBy($this->orderBy);
        }

        $this->trigger('beforeFind', ['query' => $query]);

        $perPage = $this->perPage;

        if ($perPage)
        {
            $elements = $query->paginate($perPage);
        }
        else
        {
            $elements = $query->findAll();
        }

        return $this->render($this->view, [
            'elements' => $elements,
            'pager' => $query->pager,
            'parentId' => $parentId,
            'searchModel' => $searchModel,
            'search' => $search
        ]);
    }

}