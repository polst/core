<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Behaviors;

use CodeIgniter\Model;
use BasicApp\Events\EntityBeforeFillEvent;

abstract class BaseEntitySetNullBehavior extends \BasicApp\Core\EntityBehavior
{

    public $attributes = [];

    public function onBeforeFill(EntityBeforeFillEvent $event)
    {
        if (!$event->data)
        {
            return;
        }

        foreach($this->attributes as $attribute)
        {
            if (array_key_exists($attribute, $event->data))
            {
                if (!$event->data[$attribute])
                {
                    $event->data[$attribute] = null;
                }
            }
        }
    }

}