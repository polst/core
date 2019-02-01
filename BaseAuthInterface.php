<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

interface BaseAuthInterface
{

    public static function hasPermission(string $name);

    public static function loginUrl();

    public static function logoutUrl();

    public static function getCurrentUserId();

    public static function getCurrentUser();

    public static function checkPassword(string $password, string $hash);

    public static function encodePassword(string $password);

    public static function login($user, $expire = null);

    public static function logout();

}