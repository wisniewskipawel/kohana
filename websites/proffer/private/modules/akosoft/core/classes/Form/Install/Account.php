<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Install_Account extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->add_input_text('user_name');
		
		$this->add_input_text('user_email')
			->add_validator('user_email', 'Bform_Validator_Auth_Email');
		
		$this->add_input_password('user_pass', array('required' => TRUE, 'class' => 'password'))
			->add_validator('user_pass', 'Bform_Validator_Html');
		
		$this->add_input_password('user_pass2', array('required' => TRUE, 'class' => 'password'))
			->add_validator('user_pass', 'Bform_Validator_Compare', array('msg' => ___('users.forms.confirm_pass.error.compare'), 'compare' => 'user_pass2'));
		
		$this->add_input_submit(___('form.save'));
	}
	
}