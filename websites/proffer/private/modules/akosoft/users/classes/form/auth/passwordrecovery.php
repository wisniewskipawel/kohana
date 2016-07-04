<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_PasswordRecovery extends Bform_Form {
    
	public function  create(array $params = array())
	{
		$this->add_input_email('email');
		
		$this->add_input_submit(___('form.save'));
	}
    
}
