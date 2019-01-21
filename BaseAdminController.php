<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

use CodeIgniter\Events\Events;

abstract class BaseAdminController extends Controller
{

    protected $layoutPath = 'App\Views\admin\layouts';

	protected $layout = 'main';

	public function __construct()
	{
		parent::__construct();

		Events::trigger('admin_controller_constructor');
	}

}
