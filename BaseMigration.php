<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseMigration extends \CodeIgniter\Database\Migration
{

    public $table;

    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SET_NULL = 'SET NULL';

    const CONSTRAINT = 'CONSTRAINT';

    abstract public function up();

    abstract public function down();

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
            'type' => 'CHAR',
            'constraint' => 2,
            'null' => false,
            'default' => $app->defaultLocale
        ], $params);
    }
    
    public function textColumn(array $params = [])
    {
        return array_replace([
            'type' => 'TEXT',
            'null' => true
        ], $params);
    }

    public function primaryKeyColumn(array $params = [])
    {
        return array_replace([
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true
        ], $params);
    }

    public function createdColumn(array $params = [])
    {
        return array_replace([
            'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'null' => true
        ], $params);
    }

    public function updatedColumn(array $params = [])
    {
        return array_replace([
            'type' => 'TIMESTAMP NULL',
            'default' => null
        ], $params);
    }

    public function stringColumn(array $params = [])
    {
        return array_replace([
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
            'default' => null
        ], $params);
    }

    public function integerColumn(array $params = [])
    {
        return array_merge([
            'type' => 'INT',
            'constraint' => 11,
            'null' => true,
            'default' => null
        ], $params);
    }

    public function foreignKeyColumn(array $params = [])
    {
        return $this->integerColumn(array_replace([
            'unsigned' => true
        ], $params));
    }

    public function booleanColumn(array $params = [])
    {
        return array_replace([
            'type' => 'TINYINT',
            'constraint' => 1,
            'unsigned' => true,
            'null' => false,
            'default' => 0
        ], $params);
    }

    public function sortColumn(array $params = [])
    {
        return array_replace([
            'type' => 'INT',
            'constraint' => '11',
            'unsigned' => true,
            'null' => true
        ], $params);
    }

    public function dateColumn(array $params = [])
    {    
        return array_replace([
            'type' => 'DATE',
            'null' => true,
            'default' => null
        ], $params);
    }

    public function charColumn(array $params = [])
    {    
        return array_replace([
            'type' => 'CHAR',
            'constraint' => 2,
            'null' => true,
            'default' => null
        ], $params);
    }

    public function currencyColumn(array $params = [])
    {
        return $this->charColumn(array_replace([
            'constraint' => 3
        ], $params));
    }

    public function decimalColumn(array $params = [])
    {    
        return array_replace([
            'type' => 'DECIMAL',
            'constraint' => '12,2',
            'null' => true,
            'default' => null
        ], $params);
    }

    public function keyName(string $table, array $keys)
    {
        return DbHelper::keyName($table, $keys);
    }

    public function addKey(string $table, array $keys, bool $primary = false, $unique = false)
    {
        return DbHelper::addKey($table, $keys, $primary, $unique);
    }

    public function dropKey(string $table, string $key)
    {
        return DbHelper::dropKey($table, $key);
    }

    public function addForeignKey(string $table, string $key, string $column, string $foreignTable, string $foreignTableKey, string $onDelete = 'RESTRICT', string $onUpdate = 'RESTRICT') 
    {
        return DbHelper::addForeignKey($table, $key, $column, $foreignTable, $foreignTableKey, $onDelete, $onUpdate);
    }

    public function dropForeignKey(string $table, string $key)
    {
        return DbHelper::dropForeignKey($table, $key);
    }

}