<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Interfaces\SearchModelInterface;
use denis303\traits\FactoryTrait;
use BasicApp\Traits\FieldLabelsTrait;

abstract class BaseSearchModel extends \CodeIgniter\Model implements SearchModelInterface
{

    use FactoryTrait;

    use FieldLabelsTrait;

}