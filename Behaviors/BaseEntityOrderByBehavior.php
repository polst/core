<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Behaviors;

use CodeIgniter\Model;
use BasicApp\Events\EntityAfterFillEvent;

abstract class BaseEntityOrderByBehavior extends \BasicApp\Core\EntityBehavior
{

    public $attribute;

    public $values = [];

    public function getOrderByList(array $return = [])
    {
        foreach($this->values as $key => $value)
        {
            if (array_key_exists('enabled', $value) && !$value['enabled'])
            {
                continue;
            }

            $return[$key] = $value['label'];
        }

        return $return;
    }

    public function onAfterFill(EntityAfterFillEvent $event)
    {
        if ($this->attribute)
        {
            $this->owner->{$this->attribute} = $this->getOrderBy();
        }
    }

    public function getDefaultOrderBy()
    {
        $return = null;

        foreach($this->values as $key => $value)
        {
            if (array_key_exists('enabled', $value) && !$value['enabled'])
            {
                continue;
            }

            if ($return === null)
            {
                $return = $key;
            }

            if (array_key_exists('default', $value) && $value['default'])
            {
                return $key;
            }
        }

        return $return;
    }

    public function getOrderBy()
    {
        if ($this->attribute)
        {
            $orderBy = $this->owner->{$this->attribute};

            if ($orderBy)
            {
                if (array_key_exists($orderBy, $this->values))
                {
                    if (!array_key_exists('enabled', $this->values[$orderBy]) || $this->value['enabled'])
                    {
                        return $orderBy;
                    }
                }
            }

            return $this->getDefaultOrderBy();
        }

        return null;
    }

    public function applyToQuery(Model $model)
    {
        $orderBy = $this->getOrderBy();

        if ($orderBy)
        {
            $model->orderBy($this->values[$orderBy]['value']);
        }
    }

}