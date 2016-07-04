<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_ChangePassword extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->param('i18n_namespace', 'users.forms.change_password');
		
		$auth = BAuth::instance();
		$user = $auth->get_user();
		
		$this->add_input_password('old_pass')
			->add_validator('old_pass', 'Bform_Validator_Auth_User_Password', array('user' => $user));

		$this->add_input_password('user_pass', array(
			'strength' => TRUE,
		));
		
		$this->add_input_password('user_pass2')
			->add_validator('user_pass2', 'Bform_Validator_Compare', array('msg' => ___('users.forms.confirm_pass.error.compare'), 'compare' => 'user_pass'));

		$this->add_input_submit(___('users.forms.change_password.submit'));

		$this->template('site');
	}
}
