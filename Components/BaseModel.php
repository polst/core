<?php

namespace BasicApp\Components;

abstract class BaseModel extends \CodeIgniter\Model
{

	public function attributeLabels()
	{
		return [];
	}

	public function errors(bool $forceDB = false)
	{
		$errors = parent::errors($forceDB);

		foreach($errors as $key => $value)
		{
			$errors[$key] = strtr($errors[$key], $this->attributeLabels());
		}

		return $errors;
	}

}