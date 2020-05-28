<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

abstract class BaseViewHelper
{

    public static function render(string $name, array $data = [], array $options = [])
    {
        $filename = APPPATH . 'Views/' . str_replace('\\', '/', $name) . '.php';

        if (is_file($filename))
        {
            $name = 'App\\' . $name;
        }

        return view($name, $data, $options);
    }

    public static function setVar($key, $value)
    {
        view('BasicApp\Views\data', ['data' => [$key => $value]], ['saveData' => false]);
    }

}