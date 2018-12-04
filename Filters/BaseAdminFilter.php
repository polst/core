<?php

namespace BasicApp\Filters;

use Exception;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

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
    
    	return redirect(site_url('admin/login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}