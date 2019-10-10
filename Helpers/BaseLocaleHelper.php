<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

use Config\Services;

abstract class BaseLocaleHelper
{

    public static function addLocaleToUrl($url, $locale = false)
    {
        $request = Services::request();

        $appConfig = config('App');

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
        $appConfig = config('App');

        $return  = [];

        foreach($appConfig->supportedLocales as $lang)
        {
            $return[$lang] = strtoupper($lang);
        }

        return $return;
    }

}