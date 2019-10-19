<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

use ReflectionClass;

trait GetClassDirTrait
{

    public static function classDir() : string
    {
        $className = get_called_class();

        $reflection = new ReflectionClass($className); 

        $filename = $reflection->getFileName();

        return pathinfo($filename, PATHINFO_DIRNAME);
    }

}