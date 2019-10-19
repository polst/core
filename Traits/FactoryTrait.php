<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

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