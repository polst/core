<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Interfaces;

interface UserInterface
{

    public function getPrimaryKey();

    public function getEmail();

    public function getName();

    public function getAvatarUrl();

    public function getDescription();

    public function hasRole($role) : bool;

    public function getRoles() : array; 

}