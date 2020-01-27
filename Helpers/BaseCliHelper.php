<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

use BasicApp\Helpers\FileHelper;
use BasicApp\Helpers\DownloadHelper;
use BasicApp\Helpers\ZipHelper;

abstract class BaseCliHelper
{

    public static function message($message)
    {
         echo $message . PHP_EOL;
    }

    public static function downloadToFile($url, $filename)
    {
        static::message('download: ' . $url);

        return DownloadHelper::toFile($url, $filename);
    }

    public static function zipExtractTo($filename, $target)
    {
        static::message('unzip: ' . $target);

        return ZipHelper::extractTo($filename, $target);
    }

    public static function delete($filename)
    {
        static::message('delete: ' . $filename);

        return FileHelper::delete($filename);
    }

    public static function copy($source, $target)
    {
        static::message('create: ' . $target);

        return FileHelper::copy($source, $target);
    }

    public static function setPermission($file, $permission)
    {
        static::message('permission ' . $permission . ': ' . $file);

        return FileHelper::setPermission($file, $permission);
    }    

}