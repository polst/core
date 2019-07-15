<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
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