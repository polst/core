<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Helpers;

use Config\Database;
use Exception;

abstract class BaseDbHelper
{

    public static function tableExists(string $table)
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

    public static function createRow(
        string $table, 
        array $where, 
        bool $create = false, 
        array $columns = [], 
        bool $update = false)
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

    public static function now()
    {
        $db = Database::connect();

        $query = $db->query('SELECT NOW() as now');

        $row = $query->getRow();

        return $row->now;
    }

    public static function foreignKeyName(string $table, $field)
    {
        return $table . '_' . $field . '_foreign';
    }

    public static function createForeignKey(
            string $table, 
            string $field, 
            string $foreignTable, 
            string $foreignTableField, 
            string $onDelete = 'RESTRICT', 
            string $onUpdate = 'RESTRICT',
            string $keyName = ''
        )
    {
        $db = Database::connect();

        if (!$keyName)
        {
            $keyName =  static::foreignKeyName($table, $field);
        }

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) 
            . ' ADD CONSTRAINT ' . $db->escapeIdentifiers($keyName) 
            . ' FOREIGN KEY (' . $db->escapeIdentifiers($field) . ')' 
            . ' REFERENCES ' . $db->escapeIdentifiers($foreignTable) 
            . ' (' . $db->escapeIdentifiers($foreignTableField) . ')' 
            . ' ON DELETE ' . $onDelete 
            . ' ON UPDATE '. $onUpdate 
            .';';

        return $db->query($sql);
    }

    public static function dropIndex(string $table, $key)
    {
        if (is_array($key))
        {
            $key = static::keyName($table, $key);
        }

        $db = Database::connect();

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) . ' DROP INDEX ' . $db->escapeIdentifiers($key);

        return $db->query($sql);
    }

    public static function dropUniqueKey(string $table, $key)
    {
        return static::dropIndex($table, $key);
    }

    public static function dropPrimaryKey(string $table, $key)
    {
        return static::dropPrimaryKey($table, $key);
    }    

    public static function keyName(string $table, array $columns)
    {
        $db = Database::connect();

        return $db->escapeIdentifiers($table . '_' . implode('_', $columns));
    }

    public static function createUniqueKey(string $table, array $columns, string $keyName = '')
    {
        if (!$keyName)
        {
            $keyName = static::keyName($table, $columns);
        }

        $db = Database::connect();

        $keys = implode(', ', $db->escapeIdentifiers($columns));

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) 
            . ' ADD CONSTRAINT ' . $keyName 
            . ' UNIQUE (' . $keys  . ');';

        return $db->query($sql);
    }

    public static function createPrimaryKey(string $table, array $columns, string $keyName = '')
    {
        if (!$keyName)
        {
            $keyName = static::keyName($table, $columns);
        }

        $db = Database::connect();

        $keys = implode(', ', $db->escapeIdentifiers($columns));

        $sql = 'ALTER TABLE ' . $db->escapeIdentifiers($table) 
            . ' ADD CONSTRAINT ' . $keyName 
            . ' PRIMARY KEY (' . $keys . ');';

        return $db->query($sql);
    }

    public static function createIndex(string $table, array $columns, string $keyName = '')
    {
        if (!$keyName)
        {
            $keyName = static::keyName($table, $columns);
        }

        $db = Database::connect();

        $keys = implode(', ', $db->escapeIdentifiers($columns));

        $sql = 'CREATE INDEX ' . $keyName . ' ON ' . $db->escapeIdentifiers($table) . ' (' . $keys . ');';

        return $db->query($sql);
    }

}