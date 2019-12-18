<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use BasicApp\Helpers\Url;

abstract class BaseForm extends \denis303\codeigniter4\Form
{

    public function open($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = Url::currentUrl();
        }

        return parent::open($action, $attributes, $hidden);
    }

    public function openMultipart($action = null, $attributes = [], array $hidden = []): string
    {
        if ($action === null)
        {
            $action = Url::currentUrl();
        }

        return parent::openMultipart($action, $attributes, $hidden);
    }

}