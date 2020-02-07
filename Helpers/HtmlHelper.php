<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

class HtmlHelper extends \PhpTheme\HtmlHelper\HtmlHelper
{

    public static function linkCss($href, array $options = [])
    {
        $options['rel'] = 'stylesheet';

        $options['type'] = 'text/css';

        if (!array_key_exists('media', $options))
        {
            $options['media'] = 'screen';
        }

        $options['href'] = $href;

        return static::shortTag('link', $options);
    }

    public static function scriptFile($url, array $params = [])
    {
        $params['src'] = $url;

        return static::tag('script', '', $params);
    }

}