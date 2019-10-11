<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Actions;

abstract class BaseCreateAction extends \BasicApp\Core\Action
{

    public $view;

    public function run(array $options = [])
    {
        $model = $this->createModel();

        $errors = [];

        $get = $this->request->getGet();

        $data = $this->createEntity($get);
        
        $post = $this->request->getPost();

        if ($post)
        {
            $data = $this->fillEntity($data, $post);

            if ($this->saveEntity($data, $errors))
            {
                return $this->redirectBack($this->returnUrl);
            }
        }

        return $this->render($this->view, [
            'model' => $model,
            'data' => $data,
            'errors' => $errors,
            'parentId' => $this->entityParentKey($data)
        ]);
    }

}