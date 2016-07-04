<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_User_Send_Promotions extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$email = $params['email'];
		
		$this->form_data(array(
			'subject' => $email->email_subject,
			'message' => $email->email_content,
		));
		
		$this->add_input_text('subject');
		
		$this->add_editor('message', array(
			'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
		));
		
		$this->add_input_submit(___('form.send'));
	}
}
