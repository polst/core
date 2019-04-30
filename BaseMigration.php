<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseMigration extends \CodeIgniter\Database\Migration
{

    abstract public function up();

    abstract public function down();    

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
            . ' ON UPDATE '. $onUpdate .';';

        $this->db->query($sql);
    }

    public function tableDropForeignKey(string $table, string $key)
    {
        $sql = 'ALTER TABLE ' . $this->db->escapeIdentifiers($table) . ' DROP FOREIGN KEY ' . $this->db->escapeIdentifiers($key);

        $this->db->query($sql);
    }

}