<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_Login extends Bform_Form {

	public function create(array $params = array())
	{
		$this->add_input_text('user_name', array('size' => 20));
		
		$this->add_input_password('user_password', array('size' => 20));
		
		$this->add_bool('remember', array('label' => 'users.remember'));
		
		$this->add_input_submit(___('users.login'));

		$this->template('site');
	}
}
