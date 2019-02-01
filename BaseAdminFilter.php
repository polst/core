<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
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