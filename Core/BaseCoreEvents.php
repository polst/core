<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseCoreEvents extends \CodeIgniter\Events\Events
{

    const EVENT_PRE_SYSTEM = 'pre_system';

    public static function onPreSystem($callback)
    {
        static::on(static::EVENT_PRE_SYSTEM, $callback);
    }

}