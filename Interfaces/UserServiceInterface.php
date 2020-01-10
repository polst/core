<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Interfaces;

interface UserServiceInterface extends \Denis303\Auth\UserServiceInterface
{

    public function validatePassword(string $password, string $hash);

    public function encodePassword(string $password);

}