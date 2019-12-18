<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;
use BasicApp\Helpers\CliHelper;

abstract class BaseComposer extends \Composer\Installer\LibraryInstaller
{

    public static function postCreateProject($event)
    {        
        static::runCommands($event, 'BasicApp\Core\Composer::postCreateProject');
    }

    public static function postInstall($event)
    {
        static::runCommands($event, 'BasicApp\Core\Composer::postInstall');
    }

    public static function postUpdate($event)
    {
        static::runCommands($event, 'BasicApp\Core\Composer::postUpdate');
    }

    protected static function runCommands($event, $extraKey)
    {
        $params = $event->getComposer()->getPackage()->getExtra();
  
        if (isset($params[$extraKey]) && is_array($params[$extraKey]))
        {
            foreach ($params[$extraKey] as $method => $args)
            {
                call_user_func_array([__CLASS__, $method], (array) $args);
            }
        }
    }

    protected static function copy($files)
    {
        foreach($files as $source => $target)
        {
            try
            {
                CliHelper::copy($source, $target);
            }
            catch(Exception $e)
            {
                echo $e . PHP_EOL;
            }
        }
    }

    protected static function setPermission($files)
    {
        foreach($files as $file => $permission)
        {
            try
            {
                CliHelper::setPermission($file, $permission);
            }
            catch(Exception $e)
            {
                echo $e . PHP_EOL;
            }
        }
    }

}