<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

use CodeIgniter\Events\Events;

abstract class BasePublicController extends Controller
{

	protected $layout = 'App\Views\layouts\main';

	public function __construct()
	{
		parent::__construct();

		Events::trigger('public_controller_constructor');
	}

}
