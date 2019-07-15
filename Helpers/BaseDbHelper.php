<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Helpers;

use Config\Database;
use Exception;

abstract class BaseDbHelper
{

    public static function exists(string $table)
    {
        $db = Database::connect();
        
        return $db->tableExists($table);
    }

    public static function count(string $table, array $where = [])
    {
        $db = Database::connect();

        $builder = $db->table($table);

        if ($where)
        {
            $builder->where($where);
        }

        return $builder->countAllResults();
    }

    public static function findAll(string $table, array $where = [])
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $builder->where($where);

        $query = $builder->get();

        return $query->getResultArray();
    }

    public static function findRow(string $table, array $where = [])
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $builder->where($where);

        $query = $builder->get();

        return $query->getRowArray();
    }

    public static function insertRow(string $table, array $columns = [])
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $return = $builder->insert($columns);
    
        if ($return)
        {
            return $db->insertID();
        }

        return $return;
    }

    public static function updateAll(string $table, array $columns)
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $return = $builder->update($columns);

        return $return;        
    }

    public static function updateRow(string $table, array $where, array $columns)
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $builder->where($where);

        $return = $builder->update($columns);

        return $return;
    }

    public static function replaceRow(string $table, array $where, array $columns)
    {
        $db = Database::connect();

        $builder = $db->table($table);

        $builder->where($where);

        $return = $builder->replace($columns);

        return $return;
    }

    public static function createRow(string $table, array $where, bool $create = false, array $columns = [], bool $update = false)
    {
        $db = Database::connect();

        $row = static::findRow($table, $where);

        if ($row)
        {
            if ($update)
            {
                $updated = false;

                foreach($columns as $key => $value)
                {
                    if ($row[$key] != $value)
                    {
                        $updated = true;
                    }
                }

                if ($updated)
                {
                    $result = static::updateRow($table, $where, $columns);

                    $row = static::findRow($table, $where);

                    if (!$row)
                    {
                        throw new Exception('Row not found.');
                    }
                }
            }

            return $row;
        }

        if (!$create)
        {
            return null;
        }

        $id = DbHelper::insertRow($table, array_replace($columns, $where));

        $row = static::findRow($table, $where);

        if (!$row)
        {
            throw new Exception('Row not found.');
        }

        return $row;
    }

    public static function getNow()
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

    public static function addKey(string $table, array $keys, bool $primary = false, $unique = false, string $keyName = '')
    {
        $db = Database::connect();

        if (!$keyName)
        {
            $keyName = static::keyName($table, $keys);
        }

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