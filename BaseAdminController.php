<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Events\Events;
use BasicApp\Admin\Models\AdminModel;

abstract class BaseAdminController extends Controller
{

    protected $authClass = AdminModel::class;

    protected $layoutPath = 'admin';

	protected $layout = 'layout';

    protected $roles = [self::LOGGED_ROLE];

	public function __construct()
	{
		parent::__construct();

		Events::trigger('admin_controller_constructor');
	}

}