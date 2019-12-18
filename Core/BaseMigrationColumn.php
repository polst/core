<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Config\App;

abstract class BaseMigrationColumn extends \denis303\codeigniter4\MigrationColumn
{

    public static function lang($default = null)
    {
        if ($default === null)
        {
            $app = config(App::class);
        
            $default = $app->defaultLocale;
        }

        return static::char(2)->notNull()->default($default);
    }

    public static function primaryKey($constraint = 11, $autoIncrement = true)
    {
        return parent::primaryKey($constraint, $autoIncrement)->unsigned();
    }

    public static function integer($constraint = 11)
    {
        return parent::integer($constraint);
    }

    public static function foreignKey($constraint = 11)
    {
        return parent::foreignKey($constraint)->unsigned();
    }

    public static function sort()
    {
        return static::integer(11)->unsigned();
    }

    public static function currency($constraint = 3)
    {
        return static::char($constraint);
    }

    public static function price($constraint1 = 12, $constraint2 = 2)
    {
        return static::decimal($constraint1, $constraint2);
    }

}