<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Interfaces;

interface BaseActionInterface
{

    function run(array $params = []);

    function render(string $view, array $params = []) : string;

}