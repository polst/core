<?php

namespace BasicApp;

abstract class Widget extends Component
{

	abstract public static function render();

	public static function widget($params = [])
	{
		$widget = static::factory($params);

		return $widget->render();
	}

}
