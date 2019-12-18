<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Behaviors;

use Config\Database;
use BasicApp\Core\ModelBehavior;

class BaseSortBehavior extends ModelBehavior
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