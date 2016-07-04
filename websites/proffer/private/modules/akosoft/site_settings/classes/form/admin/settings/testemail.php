<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_TestEmail extends Bform_Form {

	public function  create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_input_email('email', array('label' => 'email'));
		
		$this->add_input_submit(___('form.save'));
	}

}
