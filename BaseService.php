<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseService
{

    protected $instance;

    public function __construct(object $instance, array $params = [])
    {
        $this->instance = $instance;

        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
    }

}