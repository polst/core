<?php
/**
 * @copyright Copyright (c) 2018-2019 Basic App Dev Team
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Interfaces;

use CodeIgniter\Model;
use CodeIgniter\Entity;

interface BaseSearchModelInterface
{

    public static function applyToQuery(Entity $search, Model $query);

}