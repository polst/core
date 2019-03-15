<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseModelBehaviorInterface
{

    function beforeInsert(array $params) : array;

    function afterInsert(array $params);

    function beforeUpdate(array $params) : array;

    function afterUpdate(array $params);

    function afterFind(array $params) : array;

    function beforeDelete(array $params);

    function afterDelete(array $params);

    function beforeSave(array $params) : array;

    function afterSave(array $params) : array;

    function beforeValidate(array $params) : array;

    function afterValidate(array $params) : array;
    
}