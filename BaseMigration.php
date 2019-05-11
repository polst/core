<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseMigration extends \CodeIgniter\Database\Migration
{

    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SET_NULL = 'SET NULL';

    abstract public function up();

    abstract public function down();

    public function langColumn(array $params = [])
    {
         $app = config('app');
        
        return array_merge([
            'type' => 'CHAR',
            'constraint' => 2,
            'null' => false,
            'default' => $app->defaultLocale
        ], $params);
    }
    
    public function textColumn(array $params = [])
    {
        return array_merge([
            'type' => 'TEXT',
            'null' => true
        ], $params);
    }

    public function primaryColumn(array $params = [])
    {
        return array_merge([
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true
        ], $params);
    }

    public function createdColumn(array $params = [])
    {
        return array_merge([
            'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'null' => true
        ], $params);
    }

    public function updatedColumn(array $params = [])
    {
        return array_merge([
            'type' => 'TIMESTAMP NULL',
            'default' => null
        ], $params);
    }

    public function stringColumn(array $params = [])
    {
        return array_merge([
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
            'default' => null
        ], $params);
    }

    public function foreignColumn(array $params = [])
    {
        return array_merge([
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'null' => true,
            'default' => null
        ], $params);
    }

    public function booleanColumn(array $params = [])
    {
        return array_merge([
            'type' => 'TINYINT',
            'constraint' => 1,
            'unsigned' => true,
            'null' => false,
            'default' => 0
        ], $params);
    }

    public function sortColumn(array $params = [])
    {
        return array_merge([
            'type' => 'INT',
            'constraint' => '11',
            'unsigned' => true,
            'null' => true
        ], $params);
    }

    public function tableAddKey(string $table, array $keys, bool $primary = false, $unique = false)
    {
        if ($unique)
        {
            $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table)
              . ' ADD CONSTRAINT ' . $this->db->escapeIdentifiers($table . '_' . implode('_', $keys))
              . ' UNIQUE (' . implode(', ', $this->db->escapeIdentifiers($keys)) . ');';
        }
        elseif($primary)
        {
            $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table)
              . ' ADD CONSTRAINT ' . $this->db->escapeIdentifiers($table . '_' . implode('_', $keys))
              . ' PRIMARY KEY (' . implode(', ', $this->db->escapeIdentifiers($keys)) . ');';
        }
        else
        {
            $sql = 'CREATE INDEX ' . $this->db->escapeIdentifiers($table . '_' . implode('_', $keys))
                . ' ON ' . $this->db->escapeIdentifiers($table)
                . ' (' . implode(', ', $this->db->escapeIdentifiers($keys)) . ');';
        }

        $this->db->query($sql);
    }

    public function tableDropKey(string $table, string $key)
    {
        $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table) . ' DROP INDEX ' . $this->db->escapeIdentifiers($key);

        $this->db->query($sql);
    }

    public function tableAddForeignKey(
        string $table, 
        string $key, 
        string $column, 
        string $foreignTable, 
        string $foreignTableKey,
        string $onDelete = 'RESTRICT', 
        string $onUpdate = 'RESTRICT' ) 
    {
        $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table) 
            . ' ADD CONSTRAINT ' . $this->db->escapeIdentifiers($key) 
            . ' FOREIGN KEY(' . $this->db->escapeIdentifiers($column) . ')' 
            . ' REFERENCES ' . $this->db->escapeIdentifiers($foreignTable) . '(' . $this->db->escapeIdentifiers($this->foreignTableKey) . ')' 
            . ' ON DELETE ' . $onDelete 
            . ' ON UPDATE '. $onUpdate 
            .';';

        $this->db->query($sql);
    }

    public function tableDropForeignKey(string $table, string $key)
    {
        $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table) . ' DROP FOREIGN KEY ' . $this->db->escapeIdentifiers($key);

        $this->db->query($sql);
    }

}