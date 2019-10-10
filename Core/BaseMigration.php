<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Exception;
use BasicApp\Helpers\DbHelper;

abstract class BaseMigration extends \denis303\codeigniter4\Migration
{

    const COLUMN_CLASS = MigrationColumn::class;

    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SET_NULL = 'SET NULL';

    public $depends = [];

    abstract public function up();

    abstract public function down();

    public function __construct()
    {
        parent::__construct();

        foreach($this->depends as $table)
        {
            if (!DbHelper::tableExists($table))
            {
                throw new Exception($table . ' table does not exist.');
            }
        }
    }

    public function keyName($table, array $columns)
    {
        return DbHelper::keyName($table, $columns);
    }

    public function createIndex($table, array $keys, string $keyName = '')
    {
        return DbHelper::createIndex($table, $keys, $keyName);
    }

    public function createPrimaryKey($table, array $keys, string $keyName = '')
    {
        return DbHelper::createPrimaryKey($table, $keys, $keyName);
    }

    public function createUniqueKey($table, array $keys, string $keyName = '')
    {
        return DbHelper::createUniqueKey($table, $keys, $keyName);
    }

    public function dropIndex($table, $key)
    {
        return DbHelper::dropIndex($table, $key);
    }

    public function dropUniqueKey($table, $key)
    {
        return DbHelper::dropUniqueKey($table, $key);
    }

    public function dropPrimaryKey($table, $key)
    {
        return DbHelper::dropPrimaryKey($table, $key);
    }

    public function createForeignKey(
        string $table,
        string $fieldName,
        string $tableName, 
        string $tableField, 
        string $onDelete = 'RESTRICT', 
        string $onUpdate = 'RESTRICT',
        string $keyName = '')
    {

        return DbHelper::createForeignKey(
            $table, 
            $fieldName,
            $tableName, 
            $tableField, 
            $onDelete, 
            $onUpdate,
            $keyName
        );
    }

    public function foreignKeyName(string $table, string $field)
    {
        return DbHelper::foreignKeyName($table, $field);
    }

    public function createColumn(string $table, $field): bool
    {
        return $this->addColumn($table, $field);
    }

    public function lang($default = null)
    {
        $class = static::COLUMN_CLASS;

        return $class::lang($default);
    }

    public function sort()
    {
        $class = static::COLUMN_CLASS;

        return $class::sort();        
    }

    public function currency()
    {
        $class = static::COLUMN_CLASS;

        return $class::currency();
    }

    public function price($constraint1 = 12, $constraint2 = 2)
    {
        $class = static::COLUMN_CLASS;

        return $class::price($constraint, $constraint2);
    }

    public function deleteMigration($class)
    {
        $builder = $this->db->table('migrations');

        $builder->where(['class' => $class]);

        $count = $builder->countAllResults();

        if ($count > 0)
        {
            $builder = $this->db->table('migrations');

            $builder->where(['class' => $class]);

            $builder->delete();

            return true;
        }

        return false;
    }

}