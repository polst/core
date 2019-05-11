<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Config\App;

abstract class BaseUrl
{

    public static function createUrl($path = '', array $params = [], string $scheme = null, App $altConfig = null) : string
    {
        helper(['url']);

        if ($params)
        {
            $path .= '?' . http_build_query($params);
        }

        return site_url($path, $scheme, $altConfig);
    }

    public static function currentUriString($applyParams = [])
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

    public static function currentUrl($params = [], string $scheme = null, App $altConfig = null)
    {
        return site_url(static::currentUriString($params), $scheme, $altConfig);
    }

}