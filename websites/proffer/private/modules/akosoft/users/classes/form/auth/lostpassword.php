<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_LostPassword extends Bform_Form {
    
	public function create(array $params = array())
	{
		$this->add_input_email('user_email');
		
		$this->add_input_submit(___('users.forms.lost_password.submit'));

		$this->template('site');
	}
    
}
