<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Interfaces;

interface BaseActionInterface
{

    function run(array $params = []);

    function render(string $view, array $params = []) : string;

}