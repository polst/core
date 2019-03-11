<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseControllerIndexAction extends ControllerAction
{

    public static function run(Controller $controller, array $params = [])
    {
        $query = $controller->createQuery();

        $searchModelClass = $controller->getSearchModelClass(false);

        if ($searchModelClass)
        {
            $searchModel = $searchModelClass::factory();

            $search = $searchModel->createEntity();

            $search->fill($controller->request->getGet());

            $searchModel::applyToQuery($search, $query);
        }
        else
        {
            $searchModel = null;

            $search = null;
        }

        $parentField = $controller->getParentField();

        $parentId = null;

        if ($parentField)
        {
            $parentId = $controller->request->getGet(static::PARENT_ID_INDEX);

            if (!$parentId)
            {
                throw new PageNotFoundException;
            }

            $query->where($parentField, $parentId);
        }

        if ($controller->getOrderBy())
        {
            $query->orderBy($controller->getOrderBy());
        }

        $controller->beforeFind($query);

        $perPage = $controller->getPerPage();

        if ($perPage)
        {
            $elements = $query->paginate($perPage);
        }
        else
        {
            $elements = $query->findAll();
        } 

        return static::render($controller, [
            'elements' => $elements,
            'pager' => $query->pager,
            'parentId' => $parentId,
            'searchModel' => $searchModel,
            'search' => $search
        ]);
    }

}