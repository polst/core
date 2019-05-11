<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

use CodeIgniter\Model;
use CodeIgniter\Entity;

interface BaseSearchModelInterface
{

    public static function applyToQuery(Entity $search, Model $query);

}