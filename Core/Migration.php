<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

abstract class Migration extends BaseMigration
{

    abstract public function up();

    abstract public function down();  

}