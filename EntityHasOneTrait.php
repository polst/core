<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Closure;

trait EntityHasOneTrait
{

    public function hasOne(string $modelClass, array $where, Closure $callback = null)
    {
        $query = new $modelClass;

        $query->where($where);

        if (is_callable($callback))
        {
            $callback($query);
        }

        $return = $query->first();

        return $return;
    }

}