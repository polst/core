<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Core\Actions;

abstract class BaseCreateAction extends \BasicApp\Core\Action
{

    public $view;

    public function run(array $options = [])
    {
        $errors = [];

        $get = $this->request->getGet();

        $row = $this->createEntity($get);
        
        $post = $this->request->getPost();

        if ($post)
        {
            $row = $this->fillEntity($row, $post);

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