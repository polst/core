<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

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