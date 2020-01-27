<?php
/**
 * @author Basic App Dev Team <dev@basic-app.con>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Traits;

use Closure;

trait EntityHasManyTrait
{

    public function hasMany(string $modelClass, array $where, Closure $callback = null)
    {
        $query = new $modelClass;

        $query->where($where);

        if (is_callable($callback))
        {
            $callback($query);
        }

        return $query->findAll();
    }

}