<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_ChangePassword extends Bform_Form {

	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'users.forms.change_password');
		
		$auth = BAuth::instance();
		$user = $auth->get_user();
		
		$this->add_input_text('email', array('label' =>___('email'), 'value' => $params['user_email']))
			->add_validator('email', 'Bform_Validator_Auth_Email', array('edit' => TRUE, 'user_id' => $params['user_id']));
		
		$this->add_input_password('old_pass')
			->add_validator('old_pass', 'Bform_Validator_Auth_User_Password', array('user' => $user));

		$this->add_input_password('user_pass', array('required' => FALSE));
		
		$this->add_input_password('user_pass2', array('required' => FALSE))
			->add_validator('user_pass2', 'Bform_Validator_Compare', array('msg' => ___('users.forms.confirm_pass.error.compare'), 'compare' => 'user_pass'));

		$this->add_input_submit(___('form.save'));
	}

}
