<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core\Behaviors;

use BasicApp\Core\ModelBehavior;
use BasicApp\Core\ModelBehaviorInterface;

abstract class BaseNullBehavior extends ModelBehavior implements ModelBehaviorInterface
{

	public $fields = [];

    public function beforeSave(array $params) : array
    {
    	$data = $params['data'];

        foreach($this->fields as $field)
        {
        	if (is_array($data))
        	{
        		if (!$data[$field])
        		{
        			$data[$field] = null;
        		}
        	}
        	else
        	{
	            if (!$data->$field)
	            {
	                $data->$field = null;
	            }
        	}
        }

        $params['data'] = $data;

        return $params;
    }

}