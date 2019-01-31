<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Events\Events;

abstract class BaseAdminController extends Controller
{

    protected $layoutPath = 'admin';

	protected $layout = 'layout';

	public function __construct()
	{
		parent::__construct();

		Events::trigger('admin_controller_constructor');
	}

}
