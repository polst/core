<?php
/**
 * @package Basic App Actions
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core\Actions;

abstract class BaseViewAction extends \BasicApp\Core\Action
{

    public $view;

    public function run(array $options = [])
    {
        $errors = [];

        $row = $this->findEntity();

        return $this->render($this->view, [
            'model' => $row,
            'parentId' => $this->entityParentKey($row)
        ]);
    }

}