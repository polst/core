<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseControllerIndexAction extends ControllerAction
{

    protected $orderBy;

    protected $perPage = 25;

    protected $beforeFind;

    public function run(array $options = [])
    {
        $query = $this->createModel();

        $searchModel = $this->createSearchModel();

        if ($searchModel)
        {
            $search = $searchModel->createEntity();

            $search->fill($this->request->getGet());

            $searchModel::applyToQuery($search, $query);
        }
        else
        {
            $search = null;
        }

        $parentKey = $this->parentKey;

        if ($parentKey)
        {
            $parentId = $this->request->getGet($this->parentKeyIndex);

            if (!$parentId)
            {
                throw new PageNotFoundException;
            }

            $query->where($parentKey, $parentId);
        }
        else
        {
            $parentId = null;
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