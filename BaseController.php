<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Security\Exceptions\SecurityException;
use Config\Services;

abstract class BaseController extends \CodeIgniter\Controller
{

    const LOGGED_ROLE = '*';

    protected static $authClass;

    protected static $roles = [];

	protected $layout;

	protected $viewPath = '';

	protected $layoutPath = '';

    protected $returnUrl;

    protected $returnUrlIndex = 'returnUrl';

	public function __construct()
	{
        $this->checkAccess(true);
	}

    public static function getAuthClass()
    {
        return static::$authClass;
    }

    public static function getRoles()
    {
        return static::$roles;
    }

    public static function checkAccess(bool $throwExceptions = false)
    {
        $roles = static::getRoles();

        if (count($roles) == 0)
        {
            return true; // Allowed for all
        }

        $authClass = static::getAuthClass();

        $user = $authClass::getCurrentUser();

        if (!$user)
        {
            if ($throwExceptions)
            {
                throw SecurityException::forDisallowedAction();
            }

            return false; // Current user is guest
        }

        foreach($roles as $role)
        {
            if ($role == static::LOGGED_ROLE)
            {
                return true;
            }

            if ($authClass::userHasPermission($user, $role))
            {
                return true;
            }
        }

        if ($throwExceptions)
        {
            throw SecurityException::forDisallowedAction();
        }

        return false;
    }

	protected function render(string $view, array $params = [])
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
			return app_view($layoutPath . $this->layout, ['content' => $content]);
		}

		return $content;
	}

    protected function createAction(string $className, array $options = [])
    {
    	$options['controller'] = $this;

        $options['returnUrl'] = $this->returnUrl;

    	$options['renderFunction'] = function(string $view, array $params = []) 
    	{
        	return $this->render($view, $params);
        };

        $options['redirectBackFunction'] = function($returnUrl)
        {
            return $this->redirectBack($returnUrl);
        };

     	return $className::factory($options);
    }

	protected function getProperty($name, $default = null)
	{
		if (property_exists($this, $name))
		{
			return $this->$name;
		}

		return $default;
	}

    protected function redirectBack($defaultUrl)
    {
        $url = $this->request->getGet($this->returnUrlIndex);

        if (!$url)
        {
            $url = $defaultUrl;
        }

        helper(['url']);

        $returnUrl = site_url($url);

        return Services::response()->redirect($returnUrl);
    }

}