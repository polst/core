<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseControllerActionInterface
{

    public static function run(Controller $controller, array $params = []);

    public static function render(Controller $controller, array $params = []) : string;

}