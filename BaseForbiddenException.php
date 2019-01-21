<?php

namespace BasicApp;

abstract class BaseForbiddenException extends \CodeIgniter\Exceptions\PageNotFoundException
{

	/**
	 * Error code
	 *
	 * @var integer
	 */
	protected $code = 403;
	
	public static function forDisallowedAction($action = null)
	{
		return new static(lang('HTTP.disallowedAction'), 403);
	}

}
