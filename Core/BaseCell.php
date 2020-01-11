<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Helpers\ViewHelper;

abstract class BaseCell
{

    public static $viewPath = 'App';

    public static function renderView($view, array $params = [], array $options = [])
    {
        return ViewHelper::render(static::$viewPath . '/' . $view, $params, $options);
    }

}