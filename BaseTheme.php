<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseTheme
{

    protected $instance;

    public $baseUrl;

    public function __construct(object $instance, array $params = [])
    {
        $this->instance = $instance;

        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function widget(string $name, array $params = [])
    {
        return $this->instance->widget($name, $params);
    }

    public function url(string $uri, array $params = [])
    {
        return $this->instance->url($uri, $params);
    }

}