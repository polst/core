<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Config\Services;

abstract class BaseLocaleHelper
{

    public static function addLocaleToUrl($url, $locale = false)
    {
        $request = Services::request();

        $appConfig = config('app');

        if (!$locale)
        {
            $locale = $request->getLocale();
        }

        if ($locale != $appConfig->defaultLocale)
        {
            $url = $locale . '/' . $url;
        }

        return $url;
    }

    public static function getLangItems()
    {
        $appConfig = config('app');

        $return  = [];

        foreach($appConfig->supportedLocales as $lang)
        {
            $return[$lang] = strtoupper($lang);
        }

        return $return;
    }

}