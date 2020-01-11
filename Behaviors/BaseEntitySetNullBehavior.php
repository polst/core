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

    public $attribute;

    public function onBeforeFill(EntityBeforeFillEvent $event)
    {
        if ($event->data && $this->attribute && array_key_exists($this->attribute, $event->data))
        {
            if (!$event->data[$this->attribute])
            {
                $event->data[$this->attribute] = null;
            }
        }
    }

}