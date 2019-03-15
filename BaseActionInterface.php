<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseActionInterface
{

    function run(array $params = []);

    function render(string $view, array $params = []) : string;

}