<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
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
