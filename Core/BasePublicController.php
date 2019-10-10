<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Events\Events;

abstract class BasePublicController extends Controller
{

	protected $layout = 'layout';

	public function __construct()
	{
		parent::__construct();

		Events::trigger('public_controller_constructor');
	}

}