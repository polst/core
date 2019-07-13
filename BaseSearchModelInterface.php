<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core;

use CodeIgniter\Model;
use CodeIgniter\Entity;

interface BaseSearchModelInterface
{

    public static function applyToQuery(Entity $search, Model $query);

}