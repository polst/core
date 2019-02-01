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

}