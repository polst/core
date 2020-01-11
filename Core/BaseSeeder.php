<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseSeeder extends \CodeIgniter\Database\Seeder
{

    public function disableForeignKeys()
    {
        $this->db->simpleQuery('SET FOREIGN_KEY_CHECKS = 0');
    }

    public function enableForeignKeys()
    {
        $this->db->simpleQuery('SET FOREIGN_KEY_CHECKS = 1');
    }

}