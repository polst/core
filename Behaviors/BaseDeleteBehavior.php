<?php
/**
 * @package Basic App Behaviors
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core\Behaviors;

use Exception;
use BasicApp\Core\ModelBehavior;
use BasicApp\Core\ModelBehaviorInterface;

abstract class BaseDeleteBehavior extends ModelBehavior implements ModelBehaviorInterface
{

    public $relations = [];

    public function beforeDelete(array $params) : array
    {
        $modelClass = get_class($this->owner);

        foreach($params['id'] as $id)
        {
            $model = $modelClass::factory()->find((int) $id);

            if (!$model)
            {
                throw new Exception($modelClass . ' not found: #' . $id);
            }

            foreach($this->relations as $relation)
            {
                $elements = $model->$relation();

                foreach($elements as $related)
                {
                    if (!$related->delete())
                    {
                        throw new Exception('Delete error.');
                    }
                }
            }
        }

        return $params;

    }

}