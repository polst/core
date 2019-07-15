<?php
/**
 * @package Basic App Core
 * @link http://basic-app.com
 * @license MIT License
 */
namespace BasicApp\Actions;

use Exception;

abstract class BaseDeleteAction extends \BasicApp\Core\Action
{

    public function run(array $options = [])
    {
        $query = $this->createModel();

        $row = $this->findEntity();

        if ($this->request->getPost())
        {
            $primaryKey = $this->entityPrimaryKey($row);

            if (!$query->delete($primaryKey))
            {
                throw new Exception('Record is not deleted.');
            }
        }
        else
        {
            throw new PageNotFoundException;
        }

        return $this->redirectBack($this->returnUrl);
    }

}