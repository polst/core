<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;
use BasicApp\Traits\EntityHasOneTrait;
use BasicApp\Traits\EntityHasManyTrait;
use BasicApp\Traits\BehaviorsTrait;
use BasicApp\Events\EntityBeforeFillEvent;
use BasicApp\Events\EntityAfterFillEvent;

abstract class BaseEntity extends \CodeIgniter\Entity
{

    use BehaviorsTrait;

    use EntityHasOneTrait;
    
    use EntityHasManyTrait;
    
    protected $modelClass;

    protected $_model;

    public function __construct()
    {
        parent::__construct();

        if (!$this->modelClass)
        {
            throw new Exception('Property "modelClass" is required.');
        }
    }

    public function getModel()
    {
        if (!$this->_model)
        {
            $modelClass = $this->modelClass;
        
            $this->_model = new $modelClass;
        }

        return $this->_model;
    }

    public function getPrimaryKey()
    {
        $modelClass = $this->modelClass;

        // ToDo: remove static call 

        return $modelClass::entityPrimaryKey($this);
    }

    public function getFieldlabel($field, $default = null)
    {
        return $this->getModel()->getFieldLabel($field, $default);
    }

    public function fill(array $data = null)
    {
        $event = new EntityBeforeFillEvent;

        $event->data = $data;

        foreach($this->getCurrentBehaviors() as $behavior)
        {
            $behavior->onBeforeFill($event);
        }

        $data = $event->data;

        $return = parent::fill($data);

        $event = new EntityAfterFillEvent;

        foreach($this->getCurrentBehaviors() as $behavior)
        {
            $behavior->onAfterFill($event);
        }

        return $return;
    }    

}