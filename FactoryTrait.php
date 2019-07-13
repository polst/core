<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

trait FactoryTrait
{

    public static function factory(array $params = [])
    {
        $class = get_called_class();

        $return = new $class;

        foreach($params as $key => $value)
        {
            $return->$key = $value;
        }

        return $return;
    }

}