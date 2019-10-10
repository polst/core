<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Security\Exceptions\SecurityException;
use Config\Services;
use BasicApp\Traits\BehaviorsTrait;

abstract class BaseController extends \CodeIgniter\Controller
{

    use BehaviorsTrait;

    const ROLE_LOGGED = '*';

    protected static $authService;

    protected static $roles = [];

	protected $layout;

	protected $viewPath = '';

	protected $layoutPath = '';

    protected $returnUrl;

    protected $returnUrlIndex = 'returnUrl';

	public function __construct()
	{
        static::checkAccess(true);
	}

    public function createBehavior(string $class, array $params = [])
    {
        $params['returnUrl'] = $this->returnUrl;

        $params['renderFunction'] = function(string $view, array $params = [])
        {
            return $this->render($view, $params);
        };

        $params['redirectBackFunction'] = function($returnUrl)
        {
            return $this->redirectBack($returnUrl);
        };

        return $class::factory($params);
    }    

    public static function getAuthService()
    {
        return service(static::$authService);
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

        $authService = static::getAuthService();

        $user = $authService->getUser();


        var_dump($user);

        die;

        $userModel = $authService->getModelClass();

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
            if ($role == static::ROLE_LOGGED)
            {
                return true;
            }

            if (UserModel::userHasRole($user, $role))
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

    protected function redirect(string $url)
    {
        return Services::response()->redirect($url);
    }

    protected function redirectBack(string $defaultUrl)
    {
        $url = $this->request->getGet($this->returnUrlIndex);

        if (!$url)
        {
            $url = $defaultUrl;
        }

        helper(['url']);

        $returnUrl = site_url($url);

        return $this->redirect($returnUrl);
    }

    protected function goHome()
    {
        return $this->redirect(base_url());
    }

}