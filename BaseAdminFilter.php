<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Admin\Models\AdminModel;

abstract class BaseAdminFilter extends AuthFilter
{

    public static function getAuthModelClass()
    {
        return AdminModel::class;
    }

}