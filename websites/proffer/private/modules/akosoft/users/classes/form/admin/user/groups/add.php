<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Form_Admin_User_Groups_Add extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'users.admin.groups.form');
		
		$this->add_input_text('group_name');
		
		$this->add_textarea('group_description');
		
		$this->add_bool('group_is_admin');
		
		$this->add_input_submit(___('form.save'));
	}
	
}