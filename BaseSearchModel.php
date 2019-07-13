<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

abstract class BaseSearchModel extends \CodeIgniter\Model implements SearchModelInterface
{

    use FactoryTrait;

    use ModelEntityTrait;

}