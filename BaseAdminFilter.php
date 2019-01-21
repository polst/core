<?php

namespace BasicApp;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\UserModel;
use CodeIgniter\Security\Exceptions\SecurityException;

abstract class BaseAdminFilter implements \CodeIgniter\Filters\FilterInterface
{

    public function before(RequestInterface $request)
    {
    	$uri = $request->uri->getPath();

    	if ($uri == 'admin/login')
    	{
    		return;
    	}

    	$user = null;

		$user_id = service('session')->get('user_id');

		if ($user_id)
		{
			$user = (new UserModel)->find($user_id);
		}

		if ($user)
		{
	    	if ($user->user_admin)
	    	{
	    		return;
	    	}

			throw SecurityException::forDisallowedAction();
		}

		helper(['url']);

    	$url = site_url('admin/login');

    	return Services::response()->redirect($url);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}
