<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

trait CrudTrait
{

	protected function indexOptions(array $options = []) : array
	{
		return $options;
	}

    protected function createOptions(array $options = []) : array
    {
        return $options;
    }

    protected function updateOptions(array $options = []) : array
    {
        return $options;
    }        

    protected function deleteOptions(array $options = []) : array
    {
        return $options;
    }

	public function index()
	{
		$options = $this->indexOptions([
			'view' => 'index',
			'returnUrl' => $this->getProperty('returnUrl'),
			'modelClass' => $this->getProperty('modelClass'),
			'searchModelClass' => $this->getProperty('searchModelClass')
		]);

		$action = $this->createAction(ControllerIndexAction::class, $options);

		return $action->run(func_get_args());
	}

    public function create()
    {
        $options = $this->indexOptions([
            'view' => 'index',
            'returnUrl' => $this->getProperty('returnUrl'),
            'modelClass' => $this->getProperty('modelClass'),
            'searchModelClass' => $this->getProperty('searchModelClass')
        ]);

        $action = $this->createAction(ControllerCreateAction::class, $options);

        return $action->run(func_get_args());
    }

    public function update()
    {
        $options = $this->updateOptions([
            'view' => 'index',
            'modelClass' => $this->getProperty('modelClass'),
            'searchModelClass' => $this->getProperty('searchModelClass')
        ]);

        $action = $this->createAction(ControllerUpdateAction::class, $options);

        return $action->run(func_get_args());
    }

    public function delete()
    {
        $options = $this->deleteOptions([
            'returnUrl' => $this->getProperty('returnUrl'),
            'modelClass' => $this->getProperty('modelClass'),
            'searchModelClass' => $this->getProperty('searchModelClass')
        ]);

        $action = $this->createAction(ControllerDeleteAction::class, $options);

        return $action->run(func_get_args());
    }

}