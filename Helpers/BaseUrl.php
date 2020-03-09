<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

use Config\App;

abstract class BaseUrl
{

    public static function getCurrentLocale()
    {
        return service('request')->getLocale();
    }

    public static function createUrl($path, array $params = [], string $scheme = null, App $alt = null) : string 
    {
        helper(['url']);

        if ($params)
        {
            $path .= '?' . http_build_query($params);
        }

        $config = config(App::class);

        if ($config->defaultLocale)
        {
            $locale = static::getCurrentLocale();
          
            if ($locale && ($config->defaultLocale != $locale))
            {
                $path = $locale . '/' . $path;
            }
        }

        return site_url($path, $scheme, $alt);
    }

    public static function applyGetParams(string $query, array $params = [])
    {
        $params_list = service('request')->getGet();

        foreach($params as $key => $value)
        {
            $params_list[$key] = $value;
        }

        if ($params_list)
        {
            $query .= '?' . http_build_query($params_list);
        }

        return $query;
    }

    public static function getCurrentUri(bool $applyParams = false, array $params = [])
    {
        $return = uri_string();

        $segments = explode('/', $return);

        if (count($segments) > 0)
        {
            $locale = static::getCurrentLocale();

            if ($segments[0] == $locale)
            {
                unset($segments[0]);

                $return = implode('/', $segments);
            }
        }

        if ($applyParams)
        {
            $return = static::applyGetParams($return, $params);
        }

        return $return;        
    }    

    public static function returnUrl($path, array $params = [], string $scheme = null, App $alt = null) : string
    {
        $query = static::getCurrentUri(true);

        $params['returnUrl'] = $query;

        return static::createUrl($path, $params, $scheme, $alt);
    }

    public static function currentUrl($params = [], string $scheme = null, App $alt = null)
    {
        $params = array_merge(service('request')->getGet(), $params);

        return static::createUrl(static::getCurrentUri(), $params, $scheme, $alt);
    }

    public static function redirect(string $url, string $method = 'auto', int $code = null)
    {
        return service('response')->redirect($url, $method, $code);;
    }

}