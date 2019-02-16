<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Config\Database;

abstract class BaseDatabaseConfigModel extends \BasicApp\Core\Model
{

    protected $table = 'configs';

    protected $primaryKey = 'config_id';

    abstract static function getFormFields($model);

    abstract static function getFormName();

    public static function getValue(string $class, string $propery, string $default = '')
    {
        $model = static::get([
            'config_class' => $class,
            'config_property' => $property
        ], true, [
            'config_value' => $default
        ]);

        return $model->config_value;
    }

    public static function formValues(string $class)
    {
        $db = Database::connect();

        $query = $db->table('configs');

        $query->where('config_class', $class);

        $return = [];

        foreach ($query->get()->getResultArray() as $row)
        {
            $return[$row['config_property']] = $row['config_value'];
        }

        return $return;
    }        

    public function insert($data = null, bool $returnID = true)
    {
        $properties = [];

        foreach ($data as $property => $value)
        {
            $this->db->table($this->table)->replace([
                'config_class' => $this->returnType,
                'config_property' => $property,
                'config_value' => $value
            ]);

            $properties[] = $property;
        }

        // delete old properties

        $this->db->table($this->table)
            ->where('config_class', get_called_class())
            ->whereNotIn('config_property', $properties)
            ->delete();

        return true;
    }

}