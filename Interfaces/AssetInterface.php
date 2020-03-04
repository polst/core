<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Interfaces;

interface AssetInterface
{

    public static function register(&$head, &$beginBody = '', &$endBody = '');

}