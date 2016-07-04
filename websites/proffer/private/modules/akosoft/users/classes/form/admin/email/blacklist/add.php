<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Email_Blacklist_Add extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->add_input_email('email', array('label' => 'email', 'blacklist' => !(isset($params['is_edit']) AND $params['is_edit'])));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
