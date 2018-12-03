<?php

namespace BasicApp\Filters;

use Exception;

abstract class BaseAdminFilter implements \CodeIgniter\Filters\FilterInterface
{

    public function before(\CodeIgniter\HTTP\RequestInterface; $request)
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

    public function after(\CodeIgniter\HTTP\RequestInterface; $request, \CodeIgniter\HTTP\ResponseInterface $response)
    {
        // Do something here
    }

}