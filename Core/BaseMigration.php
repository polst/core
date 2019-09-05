<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Exception;
use BasicApp\Helpers\DbHelper;

abstract class BaseMigration extends \CodeIgniter\Database\Migration
{

    public $table;

    public $depends = [];

    public $defaultTableAttributes = [
        'MySQLi' => [
            'ENGINE' => 'InnoDb',
            'DEFAULT CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ]
    ];

    // Types

    const TYPE_VARCHAR = 'VARCHAR';

    const TYPE_DATE = 'DATE';

    const TYPE_DATETIME = 'DATETIME';

    const TYPE_DECIMAL = 'DECIMAL';

    const TYPE_TINYINT = 'TINYINT';

    const TYPE_TIMESTAMP = 'TIMESTAMP';

    const TYPE_INT = 'INT';

    const TYPE_CHAR = 'CHAR';

    const TYPE_TEXT = 'TEXT';

    // SQL

    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SET_NULL = 'SET NULL';

    // Options

    const CONSTRAINT = 'constraint';

    const DEFAULT = 'default';

    const TYPE = 'type';

    const NULL = 'null';

    const UNSIGNED = 'unsigned';

    const UNIQUE = 'unique';

    const AUTO_INCREMENT = 'auto_increment';

    // Database Settings

    const ENGINE = 'ENGINE';

    const DEFAULT_ENGINE = 'InnoDb';

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

    // Database Forge

    public function createDatabase(string $db_name): bool
    {
        return $this->forge->createDatabase($db_name);
    }

    public function dropDatabase(string $db_name): bool
    {
        return $this->forge->dropDatabase($db_name);
    }

    public function dropForeignKey(string $table, string $foreign_name)
    {
        return $this->forge->dropForeignKey($table, $foreign_name);
    }

    public function createTable(string $table, bool $if_not_exists = false, array $attributes = [])
    {
        $driver = $this->forge->getConnection()->DBDriver;

        if (array_key_exists($driver, $this->defaultTableAttributes))
        {
            foreach($this->defaultTableAttributes[$driver] as $key => $value)
            {
                if (!array_key_exists($key, $attributes))
                {
                    $attributes[$key] = $value;
                }
            }
        }

        return $this->forge->createTable($table, $if_not_exists, $attributes);
    }

    public function dropTable(string $table, bool $if_exists = false, bool $cascade = false)
    {
        return $this->forge->dropTable($table, $if_exists, $cascade);
    }

    public function renameTable(string $table, string $new_table_name)
    {
        return $this->forge->renameTable($table, $new_table_name);
    }

    public function addColumn(string $table, $field): bool
    {
        return $this->forge->addColumn($table, $field);
    }

    public function dropColumn(string $table, string $column_name)
    {
        return $this->forge->dropColumn($table, $column_name);
    }

    public function modifyColumn(string $table, $field): bool
    {
        return $this->forge->modifyColumn($table, $field);
    }

    public function reset()
    {
        $this->forge->reset();
    }

    // Columns

    public function langColumn(array $params = [])
    {
         $app = config('App');
        
        return array_replace([
            static::TYPE => static::TYPE_CHAR,
            static::CONSTRAINT => 2,
            static::NULL => false,
            static::DEFAULT => $app->defaultLocale
        ], $params);
    }
    
    public function textColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_TEXT,
            static::NULL => true
        ], $params);
    }

    public function primaryKeyColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_INT,
            static::CONSTRAINT => 11,
            static::UNSIGNED => true,
            static::AUTO_INCREMENT => true
        ], $params);
    }

    public function createdColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_TIMESTAMP . ' NULL DEFAULT CURRENT_TIMESTAMP'
        ], $params);
    }

    public function updatedColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_DATETIME,
            static::DEFAULT => null,
            static::NULL => true
        ], $params);
    }

    public function stringColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_VARCHAR,
            static::CONSTRAINT => 255,
            static::NULL => true,
            static::DEFAULT => null
        ], $params);
    }

    public function integerColumn(array $params = [])
    {
        return array_merge([
            static::TYPE => static::TYPE_INT,
            static::CONSTRAINT => 11,
            static::NULL => true,
            static::DEFAULT => null
        ], $params);
    }

    public function foreignKeyColumn(array $params = [])
    {
        return $this->integerColumn(array_replace([
            static::UNSIGNED => true
        ], $params));
    }

    public function booleanColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => 'TINYINT',
            static::CONSTRAINT => 1,
            static::UNSIGNED => true,
            static::NULL => false,
            static::DEFAULT => 0
        ], $params);
    }

    public function sortColumn(array $params = [])
    {
        return array_replace([
            static::TYPE => static::TYPE_INT,
            static::CONSTRAINT => '11',
            static::UNSIGNED => true,
            static::NULL => true
        ], $params);
    }

    public function dateColumn(array $params = [])
    {    
        return array_replace([
            static::TYPE => static::TYPE_DATE,
            static::NULL => true,
            static::DEFAULT => null
        ], $params);
    }

    public function charColumn(array $params = [])
    {    
        return array_replace([
            static::TYPE => static::TYPE_CHAR,
            static::CONSTRAINT => 2,
            static::NULL => true,
            static::DEFAULT => null
        ], $params);
    }

    public function currencyColumn(array $params = [])
    {
        return $this->charColumn(array_replace([
            static::CONSTRAINT => 3
        ], $params));
    }

    public function decimalColumn(array $params = [])
    {    
        return array_replace([
            static::TYPE => static::TYPE_DECIMAL,
            static::CONSTRAINT => '12,2',
            static::NULL => true,
            static::DEFAULT => null
        ], $params);
    }

    public function priceColumn(array $params = [])
    {
        return $this->decimalColumn(array_replace([
            static::UNSIGNED => true
        ], $params));
    }    

}