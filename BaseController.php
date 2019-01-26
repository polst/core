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

	protected $viewPath = ''; // App\Views

	protected $layoutPath = ''; // App\Views

	public function __construct()
	{
	}

	public function render(string $view, array $params = [])
	{
        $viewPath = $this->viewPath;

        if ($viewPath)
        {
            $viewPath .= '/';
        }

		$content = app_view($viewPath . $view, $params, ['saveData' => true]);

        $layoutPath = $this->layoutPath;

        if ($layoutPath)
        {
            $layoutPath .= '/';
        }

		if ($this->layout)
		{
			return view($layoutPath . $this->layout, ['content' => $content]);
		}

		return $content;
	}

}
