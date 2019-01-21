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

	protected $viewPath = 'App\Views';

	protected $layoutPath = 'App\Views\layouts';

	public function __construct()
	{
		//parent::__construct();
	}

	public function render(string $view, array $params = [])
	{
		$content = view($this->viewPath . '\\' . $view, $params, ['saveData' => true]);

		if ($this->layout)
		{
			return view($this->layoutPath . '\\' . $this->layout, ['content' => $content]);
		}

		return $content;
	}

}
