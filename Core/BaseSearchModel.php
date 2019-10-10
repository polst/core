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
use BasicApp\Traits\ModelLabelsTrait;
use BasicApp\Traits\GetDefaultPropertyTrait;

abstract class BaseSearchModel extends \CodeIgniter\Model implements SearchModelInterface
{

    use FactoryTrait;

    use ModelEntityTrait;

    use ModelLabelsTrait;    

    use GetDefaultPropertyTrait;

}