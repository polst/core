<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Actions;

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