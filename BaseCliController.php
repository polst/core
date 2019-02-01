<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

abstract class BaseCliController extends \CodeIgniter\Controller
{

	public $db;

	public function __construct()
	{
		$is_console = PHP_SAPI == 'cli' || (!isset($_SERVER['DOCUMENT_ROOT']) && !isset($_SERVER['REQUEST_URI']));

		if (!$is_console)
		{
			throw new PageNotFoundException;
		}

		$this->db = Database::connect();
	}

}