<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

abstract class BaseAuthFilter implements \CodeIgniter\Filters\FilterInterface
{

    public $userService = 'user';

    protected $_service;

    public function __construct()
    {
    }

    public function getUserService()
    {
        if (!$this->_service)
        {
            $this->_service = service($this->userService);
        }

        return $this->_service;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $userService = $this->getUserService();

        if (!$userService)
        {
            throw new Exception('Service not defined.');
        }

        $loginUrl = $userService->getLoginUrl();

        $currentUrl = current_url();

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

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }

}