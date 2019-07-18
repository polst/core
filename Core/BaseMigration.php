<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use Exception;

abstract class BaseMigration extends \CodeIgniter\Database\Migration
{

    public $table;

    public $depends = [];

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

    // Db Settings

    const ENGINE = 'ENGINE';

    const DEFAULT_ENGINE = 'InnoDb';

    abstract public function up();

    abstract public function down();

    public function __construct()
    {
        parent::__construct();

        foreach($this->depends as $table)
        {
            if (!DbHelper::exists($table))
            {
                throw new Exception($table . ' table does not exist.');
            }
        }
    }

    // DEPRECATED

    public function primaryColumn(array $params = [])
    {
        return $this->primaryKeyColumn($params);
    }

    // DEPRECATED

    public function foreignColumn(array $params = [])
    {
        return $this->foreignKeyColumn($params);
    }

    public function intColumn(array $params = [])
    {
        return $this->integerColumn($params);
    }

    public function boolColumn(array $params = [])
    {
        return $this->booleanColumn($params);
    }        

    public function langColumn(array $params = [])
    {
         $app = config('app');
        
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

    public function keyName(array $keys)
    {
        return DbHelper::keyName($this->table, $keys);
    }

    public function addKey(array $keys, bool $primary = false, bool $unique = false, string $keyName = '')
    {
        return DbHelper::addKey($this->table, $keys, $primary, $unique, $keyName);
    }

    public function dropKey(string $key)
    {
        return DbHelper::dropKey($this->table, $key);
    }

    public function addForeignKey(string $key, string $column, string $foreignTable, string $foreignTableKey, string $onDelete = 'RESTRICT', string $onUpdate = 'RESTRICT') 
    {
        return DbHelper::addForeignKey($this->table, $key, $column, $foreignTable, $foreignTableKey, $onDelete, $onUpdate);
    }

    public function dropForeignKey(string $key)
    {
        return DbHelper::dropForeignKey($this->table, $key);
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

    public function addKey($key, bool $primary = false, bool $unique = false)
    {
        return $this->forge->addKey($key, $primary, $unique);
    }

    public function addPrimaryKey($key)
    {
        return $this->forge->addPrimaryKey($key);
    }

    public function addUniqueKey($key)
    {
        return $this->forge->addUniqueKey($key);
    }

    public function addField($field)
    {
        return $this->forge->addField($field);
    }

    public function addForeignKey(string $fieldName = '', string $tableName = '', string $tableField = '', string $onUpdate = '', string $onDelete = '')
    {
        return $this->forge->addForeignKey($fieldName, $tableName, $tableField, $onUpdate, $onDelete);
    }

    public function dropForeignKey(string $table, string $foreign_name)
    {
        return $this->forge->dropForeignKey($table, $foreign_name);
    }

    public function createTable(string $table, bool $if_not_exists = false, array $attributes = [])
    {
        return $this->forge->createTable($table, $if_not_exists, $attributes);
    }

    public function dropTable(string $table_name, bool $if_exists = false, bool $cascade = false)
    {
        return $this->forge->dropTable($table_name, $if_exists, $cascade);
    }

    public function renameTable(string $table_name, string $new_table_name)
    {
        return $this->forge->renameTable($table_name, $new_table_name);
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

}