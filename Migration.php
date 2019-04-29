<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class Migration extends BaseMigration
{

    abstract public function up();

    abstract public function down();  

}