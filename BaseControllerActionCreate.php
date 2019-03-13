<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp\Core;

abstract class BaseControllerActionCreate extends ControllerAction
{

    public $view;

    public function run(array $options = [])
    {
        $errors = [];

        $row = $this->createEntity();
        
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
            'model' => $row,
            'errors' => $errors,
            'parentId' => $this->entityParentKey($row)
        ]);
    }

}