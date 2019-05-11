<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseEvents extends \CodeIgniter\Events\Events
{

    const EVENT_PRE_SYSTEM = 'pre_system';

    public static function preSystem($callback)
    {
        static::on(static::EVENT_PRE_SYSTEM, $callback);
    }

}