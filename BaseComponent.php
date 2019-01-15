<?php

namespace BasicApp;

class Component
{

	public static function factory($params = [])
	{
		$class = get_called_class();

		$return = new $class;

		foreach($key => $value)
		{
			$return->$key = $value;
		}

		return $return;
	}

}
