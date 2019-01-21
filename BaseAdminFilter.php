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

    public function before(RequestInterface $request)
    {
    	$class = UserModel::userModelClass();

    	$currentUrl = $request->uri->getPath();

    	if ($currentUrl == $class::loginUrl())
    	{
    		return;
    	}

    	$user = $class::currentUser();

		if ($user)
		{
			if ($class::checkAccess($user, $uri))
			{
				return;
			}

			throw SecurityException::forDisallowedAction();
		}

		helper(['url']);

    	$url = site_url($class::loginUrl());

    	return Services::response()->redirect($url);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}
