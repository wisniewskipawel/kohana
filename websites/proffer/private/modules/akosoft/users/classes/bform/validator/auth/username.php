<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Bform_Validator_Auth_Username extends Bform_Validator_Base {

	public function validate()
	{
		if(!empty($this->_value))
		{
			if(!Valid::regex($this->_value, '/^[a-zA-Z0-9\-_\.]+$/'))
			{
				$this->_error = ___('users.forms.validator.auth.username.error');
				$this->exception();
			}

			if(!Valid::min_length($this->_value, 2) OR !Valid::max_length($this->_value, 32))
			{
				$this->_error = ___('users.forms.validator.auth.username.error_length', array(
					':min' => 2,
					':max' => 32,
				));
				$this->exception();
			}

			$reserved_user_names = (array)Kohana::$config->load('bauth.reserved_user_names');

			if (in_array($this->_value, $reserved_user_names))
			{
				$this->_error = ___('users.forms.validator.auth.username.error_invalid');
				$this->exception();
			}

			$users_model = new Model_User;

			if ( ! empty($this->_options['edit']) AND ! empty($this->_options['user_id']))
			{
				$result = $users_model->check_user($this->_value, $this->_options['user_id']);
			}
			else
			{
				$result = $users_model->check_user($this->_value);
			}

			if ($result)
			{
				$this->_error = ___('users.forms.validator.auth.username.error_duplicate');
				$this->exception();
			}
		}

		return TRUE;
	}
}
