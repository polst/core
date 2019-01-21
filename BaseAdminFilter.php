<?php

namespace BasicApp;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\UserModel;
use CodeIgniter\Security\Exceptions\SecurityException;

abstract class BaseAdminFilter implements \CodeIgniter\Filters\FilterInterface
{

	protected $loginUrl = 'admin/login';

	protected function currentUserId()
	{
		return service('session')->get('user_id');
	}

	protected function checkAccess($user, $uri = false)
	{
    	if ($user->user_admin)
    	{
    		return true;
    	}

    	return false;
	}

	protected function getUser($userId)
	{
		return (new UserModel)->find($userId);
	}

    public function before(RequestInterface $request)
    {
    	$uri = $request->uri->getPath();

    	if ($uri == $this->loginUrl)
    	{
    		return;
    	}

    	$user = null;

		$user_id = $this->currentUserId();

		if ($user_id)
		{
			$user = $this->getUser($user_id);
		}

		if ($user)
		{
			if (static::checkAccess($user, $uri))
			{
				return;
			}

			throw SecurityException::forDisallowedAction();
		}

		helper(['url']);

    	$url = site_url($this->loginUrl);

    	return Services::response()->redirect($url);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}
