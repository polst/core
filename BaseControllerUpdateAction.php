<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseControllerUpdateAction extends ControllerAction
{

    public $view;

    public $returnUrl;

    public $modelClass;

    public $parentFieldIndex = 'parentId';

    public function run(array $options = [])
    {
        $errors = [];

        $row = $this->findEntity($options);

        $post = $this->request->getPost();

        if ($post)
        {
            $this->fillEntity($row, $post);

            if ($this->saveEntity($row, $errors))
            {
                return $this->redirectBack($this->returnUrl);
            }
        }

        return $this->render($this->view, [
            'errors' => $errors,
            'model' => $row,
            'parentId' => $this->entityParentKey($row)
        ]);        
    }

}