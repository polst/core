<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use Config\Database;

abstract class BaseDbHelper
{

    public static function now()
    {
        $db = Database::connect();

        $query = $db->query('SELECT NOW() as now');

        $row = $query->getRow();

        return $row->now;
    }

    public static function dropForeignKey(string $table, string $key)
    {
        $db = Database::connect();

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) . ' DROP FOREIGN KEY ' . $db->escapeIdentifiers($key);

        return $db->query($sql);
    }

    public static function addForeignKey(
            string $table, 
            string $key, 
            string $column, 
            string $foreignTable, 
            string $foreignTableKey, 
            string $onDelete = 'RESTRICT', 
            string $onUpdate = 'RESTRICT'
        )
    {
        $db = Database::connect();

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) 
            . ' ADD CONSTRAINT ' . $db->escapeIdentifiers($key) 
            . ' FOREIGN KEY(' . $db->escapeIdentifiers($column) . ')' 
            . ' REFERENCES ' . $db->escapeIdentifiers($foreignTable) . '(' . $db->escapeIdentifiers($foreignTableKey) . ')' 
            . ' ON DELETE ' . $onDelete 
            . ' ON UPDATE '. $onUpdate 
            .';';

        return $this->db->query($sql);
    }

    public static function dropKey(string $table, string $key)
    {
        $db = Database::connect();

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) . ' DROP INDEX ' . $db->escapeIdentifiers($key);

        return $db->query($sql);
    }

    public static function keyName(string $table, array $keys)
    {
        $db = Database::connect();

        return $db->escapeIdentifiers($table . '_' . implode('_', $keys));
    }

    public function addKey(string $table, array $keys, bool $primary = false, $unique = false)
    {
        $db = Database::connect();

        $keyName = static::keyName($table, $keys);

        $keys = implode(', ', $db->escapeIdentifiers($keys));

        if ($unique)
        {
            $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) . ' ADD CONSTRAINT ' . $keyName . ' UNIQUE (' . $keys  . ');';
        }
        elseif($primary)
        {
            $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) . ' ADD CONSTRAINT ' . $keyName . ' PRIMARY KEY (' . $keys . ');';
        }
        else
        {
            $sql = 'CREATE INDEX ' . $keyName . ' ON ' . $db->escapeIdentifiers($table) . ' (' . $keys . ');';
        }

        return $db->query($sql);
    }

}