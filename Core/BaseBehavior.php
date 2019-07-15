<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use BasicApp\Traits\FactoryTrait;
use BasicApp\Interfaces\BehaviorInterface;

abstract class BaseBehavior implements BehaviorInterface
{

	use FactoryTrait;

	protected $owner;

}