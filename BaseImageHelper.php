<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Config\Services;

abstract class BaseImageHelper
{

	public static function square($source, $target = null)
	{
        if (!$target)
        {
            $target = $source;
        }

		$info = Services::image()
			->withFile($source)
			->getFile()
			->getProperties(true);

		$min_size = min($info['width'], $info['height']);

		$x = 0;

		$y = 0;

		if ($info['width'] > $min_size)
		{
			$x = floor(($info['width'] - $min_size) / 2);
		}

		if ($info['height'] > $min_size)
		{
			$y = floor(($info['height'] - $min_size) / 2);
		}

		return Services::image()
			->withFile($source)
			->crop($min_size, $min_size, $x, $y)
			->save($target);
	}

}