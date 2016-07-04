<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Email_Edit extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->form_data($params);
		
		$this->add_input_text('email_subject');
		
		$this->add_editor('email_content', array(
			'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
		));
		
		$this->add_input_submit(___('form.save'));
	}
}
