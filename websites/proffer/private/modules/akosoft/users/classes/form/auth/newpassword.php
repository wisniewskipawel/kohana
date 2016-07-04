<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_NewPassword extends Bform_Form {
    
	public function  create(array $params = array())
	{
		$this->add_input_password('user_pass', array(
			'label' => 'users.forms.new_password.user_pass',
			'strength' => TRUE,
		))
			->add_validator('user_pass', 'Bform_Validator_Html');
		
		$this->add_input_password('user_pass2', array('label' => 'users.forms.new_password.user_pass2'))
			->add_validator('user_pass2', 'Bform_Validator_Compare', array('compare' => 'user_pass', 'msg' => ___('users.forms.confirm_pass.error.compare')));
		
		$this->add_input_submit(___('users.forms.new_password.submit'));

		$this->template('site');
	}   
}
