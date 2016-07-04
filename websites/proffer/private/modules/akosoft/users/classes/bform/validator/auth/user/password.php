<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Auth_User_Password extends Bform_Validator_Base {

	public function validate()
	{
		if(!empty($this->_value))
		{
			$user = $this->_options['user'];
			
			$password = BAuth::hash_password($this->_value);

			$model_users = new Model_User;

			if ( ! $model_users->check_password($user->pk(), $password)) 
			{
				$this->_error = ___('users.forms.validator.auth.user.password.error');
				$this->exception();
			}
		}
	}
}
