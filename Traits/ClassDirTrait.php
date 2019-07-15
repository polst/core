<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Traits;

use ReflectionClass;

trait ClassDirTrait
{

    public function getClassDir() : string
    {
        $className = get_class($this);

        $reflection = new ReflectionClass($className); 

        $filename = $reflection->getFileName();

        return pathinfo($filename, PATHINFO_DIRNAME);
    }

}