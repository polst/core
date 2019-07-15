<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

abstract class BaseWidget extends Component
{

	abstract public function render();

	public static function widget($params = [])
	{
		$widget = static::factory($params);

		return $widget->render();
	}

}