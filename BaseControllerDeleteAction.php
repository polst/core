<?php

namespace BasicApp\Core;

use Exception;

abstract class BaseControllerDeleteAction extends ControllerAction
{

    public function delete()
    {
        $query = $this->createQuery();

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