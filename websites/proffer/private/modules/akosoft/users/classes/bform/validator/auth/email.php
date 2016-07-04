<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Auth_Email extends Bform_Validator_Base {

	public function validate()
	{
		if (!empty($this->_value)) 
		{
			if(!Valid::email($this->_value))
			{
				$this->_error = ___('forms.validator.email');
				$this->exception();
			}
			
			$users_model = new Model_User;

			if ( ! empty($this->_options['edit']) AND ! empty($this->_options['user_id']))
			{
				$result = $users_model->check_email($this->_value, $this->_options['user_id']);
			}
			else
			{
				$result = $users_model->check_email($this->_value);
			}

			if ($result)
			{
				$this->_error = ___('users.forms.validator.auth.email.duplicate');
				$this->exception();
			}
		}
	}
}
