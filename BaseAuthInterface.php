<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseAuthInterface
{

    public static function userHasPermission($user, string $permission);

    public static function getLoginUrl();

    public static function getLogoutUrl();

    public static function getCurrentUserId();

    public static function getCurrentUser();

    public static function checkPassword(string $password, string $hash);

    public static function encodePassword(string $password);

    public static function login($user, $expire = null);

    public static function logout();

}