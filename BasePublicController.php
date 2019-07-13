<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
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