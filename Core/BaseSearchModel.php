<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Interfaces\SearchModelInterface;
use BasicApp\Traits\FactoryTrait;
use BasicApp\Traits\ModelEntityTrait;
use BasicApp\Traits\FieldLabelsTrait;
use BasicApp\Traits\DefaultPropertyTrait;

abstract class BaseSearchModel extends \CodeIgniter\Model implements SearchModelInterface
{

    use FactoryTrait;

    use ModelEntityTrait;

    use FieldLabelsTrait;    

    use DefaultPropertyTrait;

}