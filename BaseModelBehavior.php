<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseModelBehavior implements ModelBehaviorInterface
{

    public static function afterFind(array $params) : array
    {
        return $params;
    }

    public static function beforeInsert(array $params) : array
    {
        return $params;
    }

    public static function afterInsert(array $params)
    {
    }

    public static function beforeUpdate(array $params) : array
    {
        return $params;
    }

    public static function afterUpdate(array $params)
    {
    }

    public static function beforeDelete(array $params)
    {
    }

    public static function afterDelete(array $params)
    {
    }

    public static function getValidationRules(array $params) : array
    {
        return $params;
    }

    public static function beforeSave(array $params) : array
    {
        return $params;
    }

    public static function afterSave(array $params) : array
    {
        return $params;
    }

}