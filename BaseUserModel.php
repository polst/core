<?php
/**
 * @package Basic App Core
 * @license MIT License
 * @link    http://basic-app.com
 */
namespace BasicApp;

abstract class BaseUserModel extends Model
{

	protected static $_currentUser;

	public static function userModelClass()
	{
		return 'App\Models\UserModel';
	}

	public static function currentUserId()
	{
		return service('session')->get('user_id');
	}

	public static function currentUser()
	{
		if (!static::$_currentUser)
		{
			$user_id = static::currentUserId();

			if ($user_id)
			{
				$class = static::userModelClass();

				$model = new $class;

				static::$_currentUser = $model->find($user_id);
			}
		}
	
		return static::$_currentUser;
	}

	protected static function checkAccess($user, $uri = false)
	{
    	if ($user->user_admin)
    	{
    		return true;
    	}

    	return false;
	}

	protected static function loginUrl()
	{
		return 'admin/login';		
	}

}
