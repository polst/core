<?php

namespace BasicApp\Components;

abstract class BaseModel extends \CodeIgniter\Model
{

	public function attributeLabels()
	{
		return [];
	}

	public function errors()
	{
		$errors = parent::errors();

		foreach($errors as $key => $value)
		{
			$errors[$key] = strtr($errors[$key], $this->attributeLabels());
		}

		return $errors;
	}

}