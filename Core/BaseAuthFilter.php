<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

abstract class BaseAuthFilter implements \CodeIgniter\Filters\FilterInterface
{

    public $userService = 'user';

    public function before(RequestInterface $request)
    {
        $userService = service($this->userService);

        $loginUrl = $userService->getLoginUrl();

        $currentUrl = (string) $request->uri; //$request->uri->getPath();
        
        if ($currentUrl == $loginUrl)
        {
            return;
        }

        $user = $userService->getUser();

        if ($user)
        {
            return;
        }

        return Services::response()->redirect($loginUrl);
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }

}