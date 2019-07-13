<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core\Behaviors;

use Config\Database;

class BaseSortBehavior extends \BasicApp\Core\ModelBehavior
{

    public $fields = [];

    public function afterSave(array $params) : array
    {
        $table = $this->owner->table;

        $primaryKey = $this->owner->primaryKey;

        $db = Database::connect();

        foreach($this->fields as $field)
        {
            $query = $db->table($table)
                ->set($field, $primaryKey, false)
                ->where($field . ' IS NULL', null, false);

            $query->update();
        }

        return $params;
    }

}