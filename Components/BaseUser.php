<?php

namespace BasicApp\Components;

use App\Models\UserModel;
//use Config\Services;

abstract class BaseUser
{

	protected $_user;

	public function getUser()
	{
		if (!$this->_user)
		{
			//$user_id = Services::session()->get('user_id');

			$user_id = service('session')->get('user_id');

			if ($user_id)
			{
				$this->_user = (new UserModel)->find($user_id);
			}
		}
	
		return $this->_user;
	}

}