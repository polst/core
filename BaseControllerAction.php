<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Database\Exceptions\DataException;

abstract class BaseControllerAction implements ControllerActionInterface
{

	use FactoryTrait;

	public $controller;

	public $createModel;

	public $createSearchModel;

	public $renderer;

	const EVENT_CREATE_MODEL = 'createModel';

	const EVENT_CREATE_SEARCH_MODEL = 'createSearchModel';

	/**
	 * A simple event trigger for Action Events that allows additional
	 * data manipulation within the action.
	 *
	 * @param string $event
	 * @param array  $data
	 *
	 * @return mixed
	 * @throws \CodeIgniter\Database\Exceptions\DataException
	 */
	public function trigger(string $event, array $data)
	{
		if (!isset($this->{$event}) || empty($this->{$event}))
		{
			return $data;
		}

		foreach ($this->{$event} as $callback)
		{
			if (!method_exists($this, $callback))
			{
				throw DataException::forInvalidMethodTriggered($callback);
			}

			$data = $this->{$callback}($data);
		}

		return $data;
	}

	public function createModel(string $className, array $options = [])
	{
		$model = $className::factory($options);

		$this->trigger(static::EVENT_CREATE_MODEL, ['model' => $model]);

		return $model;
	}

	public function createSearchModel(string $className, array $options = [])
	{
		$searchModel = $className::factory($options);

		$this->trigger(static::EVENT_CREATE_SEARCH_MODEL, ['searchModel' => $searchModel]);

		return $searchModel;
	}

	public function render(string $view, array $params = []) : string
	{
		$function = $this->renderer;

		return $function($view, $params);
	}

}