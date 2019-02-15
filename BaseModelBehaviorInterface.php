<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseModelBehaviorInterface
{

    static function beforeInsert(array $params) : array;

    static function afterInsert(array $params);

    static function beforeUpdate(array $params) : array;

    static function afterUpdate(array $params);

    static function afterFind(array $params) : array;

    static function beforeDelete(array $params);

    static function afterDelete(array $params);

    static function beforeSave(array $params) : array;

    static function afterSave(array $params) : array;

    static function beforeValidate(array $params) : array;

    static function afterValidate(array $params) : array;
    
}