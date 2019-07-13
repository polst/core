<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Core\Actions\IndexAction;
use BasicApp\Core\Actions\CreateAction;
use BasicApp\Core\Actions\UpdateAction;
use BasicApp\Core\Actions\DeleteAction;
use BasicApp\Core\Actions\ViewAction;

class BaseAdminCrudController extends AdminController
{

	protected $modelClass;

	protected $searchModelClass;

	protected $perPage;

	protected $orderBy;

	protected $parentKey;

	public function behaviors()
	{
		return [
			'index' => [
				'class' => IndexAction::class,
				'view' => 'index',
				'modelClass' => $this->modelClass,
				'searchModelClass' => $this->searchModelClass,
	            'perPage' => $this->perPage,
	            'orderBy' => $this->orderBy,
	            'parentKey' => $this->parentKey				
			],
			'create' => [
				'class' => CreateAction::class,
	            'view' => 'create',
	            'modelClass' => $this->modelClass,
	            'searchModelClass' => $this->searchModelClass,
	            'parentKey' => $this->parentKey
			],
			'update' => [
				'class' => UpdateAction::class,
	            'view' => 'update',
	            'modelClass' => $this->modelClass,
	            'searchModelClass' => $this->searchModelClass,
	            'parentKey' => $this->parentKey				
			],
			'view' => [
				'class' => ViewAction::class,
	            'view' => 'view',
	            'modelClass' => $this->modelClass,
	            'searchModelClass' => $this->searchModelClass,
	            'parentKey' => $this->parentKey				
			],
			'delete' => [
				'class' => DeleteAction::class,
	            'modelClass' => $this->modelClass,
	            'searchModelClass' => $this->searchModelClass,
	            'parentKey' => $this->parentKey				
			]
		];
	}
	
    public function index()
    {
    	return $this->as('index')->run();
    }

    public function create()
    {
    	return $this->as('create')->run();
    }

    public function update()
    {
    	return $this->as('update')->run();
    }

    public function view()
    {
    	return $this->as('view')->run();
    }

    public function delete()
    {
    	return $this->as('delete')->run();
    }

}