<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Interfaces;

use CodeIgniter\Model;
use CodeIgniter\Entity;

interface SearchModelInterface
{

    public static function applyToQuery(Entity $search, Model $query);

}