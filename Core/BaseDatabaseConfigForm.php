<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Config\Database;
use BasicApp\Core\Form;

abstract class BaseDatabaseConfigForm extends \BasicApp\Core\Model
{

    protected $table = 'configs';

    protected $primaryKey = 'config_id';

    abstract static function renderFields(Form $form);

    abstract static function getFormName();

    public static function getValue(string $class, string $propery, string $default = '')
    {
        $params = [
            'config_class' => $class,
            'config_property' => $property
        ];

        $model = static::get($params, true, ['config_value' => $default]);

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

    public static function setValue(string $class, string $property, string $value)
    {
        $db = Database::connect();

        $query = $db->table('configs');

        return $query->replace([
            'config_class' => $class,
            'config_property' => $property,
            'config_value' => $value
        ]);
    }

    public function insert($data = null, bool $returnID = true)
    {
        if ($this->validate($data) === false)
        {
            return false;
        }

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

        // delete not used old properties

        $this->db->table($this->table)
            ->where('config_class', get_called_class())
            ->whereNotIn('config_property', $properties)
            ->delete();

        return true;
    }

}