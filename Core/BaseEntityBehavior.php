<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Interfaces\EntityBehaviorInterface;
use BasicApp\Core\Behavior;
use BasicApp\Events\EntityBeforeFillEvent;
use BasicApp\Events\EntityAfterFillEvent;

abstract class BaseEntityBehavior extends Behavior implements EntityBehaviorInterface
{

    public function onBeforeFill(EntityBeforeFillEvent $event)
    {
    }

    public function onAfterFill(EntityAfterFillEvent $event)
    {
    }

}