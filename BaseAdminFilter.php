<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\Security\Exceptions\SecurityException;

abstract class BaseAdminFilter implements \CodeIgniter\Filters\FilterInterface
{

	public static function adminModelClass()
	{
		return BasicApp\Admin\Models\AdminModel::class;
	}

    public function before(RequestInterface $request)
    {
    	$class = static::adminModelClass();

    	$currentUrl = $request->uri->getPath();

    	$loginUrl = $class::adminLoginUrl();

    	if ($currentUrl == $loginUrl)
    	{
    		return;
    	}

    	$user = $class::currentAdmin();

		if ($user)
		{
			if ($class::checkAdminAccess($user, $currentUrl))
			{
				return;
			}

			throw SecurityException::forDisallowedAction();
		}

		helper(['url']);

    	$url = site_url($loginUrl);

    	return Services::response()->redirect($url);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}
