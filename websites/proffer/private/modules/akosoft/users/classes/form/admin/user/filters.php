<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_User_Filters extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		$this->method('get');

		$this->add_input_text('login_or_email', array('required' => FALSE));
		$this->add_input_submit(___('form.save'));
	}
}
