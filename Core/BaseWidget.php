<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Helpers\ViewHelper;
use denis303\traits\FactoryTrait;

abstract class BaseWidget
{

    use FactoryTrait;

	abstract public function run();

    public $viewPath = 'App';

	public static function widget($params = [])
	{
		$widget = static::factory($params);

		return $widget->run();
	}

    public function render($view, array $params = [], array $options = [])
    {
        return ViewHelper::render($this->viewPath . '/' . $view, $params, $options);
    }

}