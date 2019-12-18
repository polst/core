<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Interfaces;

use BasicApp\Events\EntityBeforeFillEvent;
use BasicApp\Events\EntityAfterFillEvent;

interface EntityBehaviorInterface extends BehaviorInterface
{

    function onBeforeFill(EntityBeforeFillEvent $event);

    function onAfterFill(EntityAfterFillEvent $event);
    
}