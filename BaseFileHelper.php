<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;

abstract class BaseFileHelper
{

    public static function copyDirectories($directories, $permissions = 0755)
    {
        foreach($directories as $source => $target)
        {
            static::copyDirectory($source, $target, $permissions);
        }
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @author Aidan Lister <aidan@php.net>
     * @version 1.0.1
     * @link http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @param string $source Source path
     * @param string $dest Destination path
     * @param int $permissions New folder creation permissions
     * @return bool Returns true on success, false on failure
     */
    function copyDirectory($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source))
        {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source))
        {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest))
        {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        
        while (false !== $entry = $dir->read())
        {
            // Skip pointers
            if ($entry == '.' || $entry == '..')
            {
                continue;
            }

            // Deep copy directories
            static::copyDirectory("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();

        return true;
    }

    public static function setPermission($path, $permission)
    {
        if (is_file($path) || is_dir($path))
        {
            chmod($path, $permission);
        }
    }

    public static function setPermissions(array $files)
    {
        foreach($files as $path => $permission)
        {
            static::setPermission($path, $permission);
        }
    }

}