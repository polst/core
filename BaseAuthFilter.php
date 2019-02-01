<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\Security\Exceptions\SecurityException;
use BasicApp\User\Models\UserModel;

abstract class BaseAuthFilter implements \CodeIgniter\Filters\FilterInterface
{

	public static function getAuthModelClass()
	{
		return UserModel::class;
	}

    public function before(RequestInterface $request)
    {
    	$class = static::getAuthModelClass();

    	$currentUrl = $request->uri->getPath();

    	$loginUrl = $class::getLoginUrl();

    	if ($currentUrl == $loginUrl)
    	{
    		return;
    	}

    	$user = $class::getCurrentUser();

		if ($user)
		{
            return;
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