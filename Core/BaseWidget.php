<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Helpers\ViewHelper;

abstract class BaseWidget extends Component
{

	abstract public function run();

    public $viewNamespace = 'App';

	public static function widget($params = [])
	{
		$widget = static::factory($params);

		return $widget->run();
	}

    public function render($view, array $params = [], array $options = [])
    {
        return ViewHelper::render($this->viewNamespace . '/' . $view, $params, $options);
    }

}