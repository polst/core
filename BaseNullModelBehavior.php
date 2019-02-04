<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseNullModelBehavior extends ModelBehavior
{

    public static function beforeSave(array $params) : array
    {
        foreach($params['fields'] as $field)
        {
            if (!($params['data'])->$field)
            {
                ($params['data'])->$field = null;
            }
        }

        return $params;
    }

}