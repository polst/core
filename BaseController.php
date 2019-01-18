<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseController extends \CodeIgniter\Controller
{

	protected $layout;

	public function __construct()
	{
		//parent::__construct();
	}

	public function render(string $view, array $params = [])
	{
		$content = view($view, $params, ['saveData' => true]);

		if ($this->layout)
		{
			return view($this->layout, ['content' => $content]);
		}

		return $content;
	}

}
