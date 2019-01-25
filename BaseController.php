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
	}

	public function render(string $view, array $params = [])
	{
        $viewPath = $this->viewPath;

        $customView = APPPATH . str_replace('\\', '/', $viewPath) . '/' . $view . '.php';

        if (is_file($customView))
        {
            $viewPath = 'App\\' . $viewPath;
        }

		$content = view($viewPath . '/' . $view, $params, ['saveData' => true]);

		if ($this->layout)
		{
			return view($this->layoutPath . '/' . $this->layout, ['content' => $content]);
		}

		return $content;
	}

}
