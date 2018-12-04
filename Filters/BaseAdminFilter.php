<?php

namespace BasicApp\Filters;

use Exception;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

abstract class BaseAdminFilter implements \CodeIgniter\Filters\FilterInterface
{

    public function before(RequestInterface $request)
    {
    	if ($request->uri->getPath() == 'admin/login')
    	{
    		return;
    	}

    	$service = service('user');

    	$user = $service->getUser();

    	if ($user && $user->user_admin)
    	{
    		return;
    	}

    	$url = site_url('admin/login');

    	return Services::response()->redirect($url);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}