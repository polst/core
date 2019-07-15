<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Helpers;

use Config\App;

abstract class BaseUrl
{

    public static function returnUrl($path, array $params = [], string $scheme = null, App $alt = null) : string
    {
        $params['returnUrl'] = static::currentUriString();

        return static::createUrl($path, $params, $scheme, $alt);
    }

    public static function createUrl($path, array $params = [], string $scheme = null, App $alt = null) : string 
    {
        helper(['url']);

        if ($params)
        {
            $path .= '?' . http_build_query($params);
        }

        return site_url($path, $scheme, $alt);
    }

    public static function currentUri($applyParams = [])
    {
        $return = uri_string();

        $params = $_GET;

        foreach($applyParams as $key => $value)
        {
            $params[$key] = $value;
        }

        if ($params)
        {
            $return .= '?' . http_build_query($params);
        }

        return $return;
    }

    public static function currentUriString($applyParams = [])
    {
        return static::currentUri($applyParams);
    }

    public static function currentUrl($params = [], string $scheme = null, App $altConfig = null)
    {
        return site_url(static::currentUriString($params), $scheme, $altConfig);
    }

}