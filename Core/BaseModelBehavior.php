<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Interfaces\ModelBehaviorInterface;
use BasicApp\Core\Behavior;

abstract class BaseModelBehavior extends Behavior implements ModelBehaviorInterface
{

    public function afterFind(array $params) : array
    {
        return $params;
    }

    public function beforeInsert(array $params) : array
    {
        return $params;
    }

    public function afterInsert(array $params)
    {
    }

    public function beforeUpdate(array $params) : array
    {
        return $params;
    }

    public function afterUpdate(array $params)
    {
    }

    public function beforeDelete(array $params)
    {
    }

    public function afterDelete(array $params)
    {
    }

    public function beforeValidate(array $params) : array
    {
        return $params;
    }

    public function afterValidate(array $params) : array
    {
        return $params;
    }

    public function beforeSave(array $params) : array
    {
        return $params;
    }

    public function afterSave(array $params) : array
    {
        return $params;
    }

}