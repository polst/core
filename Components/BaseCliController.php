<?php

namespace BasicApp\Components;

use BasicApp\Exceptions\PageNotFoundException;
use Config\Database;

abstract class BaseCliController extends \CodeIgniter\Controller
{

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