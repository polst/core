<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

abstract class BaseBehavior implements BehaviorInterface
{

	use FactoryTrait;

	protected $owner;

}