<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseTheme extends Service
{

    public $baseUrl;

    public function widget(string $name, array $params = [])
    {
        return $this->instance->widget($name, $params);
    }

    public function url(string $uri, array $params = [])
    {
        return $this->instance->url($uri, $params);
    }

}