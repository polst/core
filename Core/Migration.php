<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

abstract class Migration extends BaseMigration
{

    abstract public function up();

    abstract public function down();  

}