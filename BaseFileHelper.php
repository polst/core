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

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @author Aidan Lister <aidan@php.net>
     * @author Basic App Dev Team <dev@basic-app.com>
     * @link http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @param string $source Source path
     * @param string $dest Destination path
     * @param int $permissions New folder creation permissions
     * @return bool Returns true on success, false on failure
     */
    public static function copy($source, $dest = null, $permissions = 0755, $throwExceptions = true)
    {
        // Check for symlinks
        if (is_link($source))
        {
            $return = symlink(readlink($source), $dest);
       
            if (!$return && $throwExceptions)
            {
                throw new Exception($source . ' to ' . $dest . ' symlink error.');
            }

            return $return;
        }

        // Simple copy for a file
        if (is_file($source))
        {
            $return = copy($source, $dest);

            if (!$return && $throwExceptions)
            {
                throw new Exception($source . ' to ' . $dest . ' copy error.');
            }

            return $return;
        }

        // Make destination directory
        if (!is_dir($dest))
        {
            $return = mkdir($dest, $permissions);
            
            if (!$return && $throwExceptions)
            {
                throw new Exception($dest . ' mkdir error.');
            }

            if (!$return)
            {
                return false;
            }
        }

        // Loop through the folder
        $dir = dir($source);

        if (!$dir)
        {
            if (!$return && $throwExceptions)
            {
                throw new Exception($source . ' dir error.');
            }

            if (!$return)
            {
                return false;
            }
        }
        
        while(false !== ($entry = $dir->read()))
        {
            // Skip pointers
            if ($entry == '.' || $entry == '..')
            {
                continue;
            }

            // Deep copy directories
            $result = static::copy("$source/$entry", "$dest/$entry", $permissions);
        
            if (!$result)
            {
                // Clean up
                $dir->close();

                return false;
            }
        }

        // Clean up
        $dir->close();

        return true;
    }

    public static function setPermission($files, $permission = null, $throwExceptions = true)
    {
        if (is_file($files) || is_dir($files))
        {
            $result = chmod($files, octdec($permission));
        
            if (!$return && $throwExceptions)
            {
                throw new Exception($files . ' chmod ' . $permission . ' error.');
            }

            if (!$return)
            {
                return false;
            }
        }

        return true;
    }

}