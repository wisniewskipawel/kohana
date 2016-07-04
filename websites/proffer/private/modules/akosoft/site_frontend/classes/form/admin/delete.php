<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Delete extends BForm_Form {
	
	protected $_email = NULL;
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'admin.delete.form');
		
		$this->_email = $params['email'];
		
		if($this->_email)
		{
			$this->add_fieldset('email', ___('admin.delete.form.email_fieldset'));

			$this->email->add_bool('send_email');
			$this->email->add_input_text('subject', array('required' => !!$this->form_data('send_email')));
			$this->email->add_editor('message', array(
				'required' => !!$this->form_data('send_email'),
				'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
			));
		}
		
		$this->add_html(___('admin.delete.form.delete_text', array(
			':title' => HTML::chars($params['delete_text']),
		)));
		
		$this->add_input_submit(___('form.save'));
	}
	
	public function send_message()
	{
		$values = $this->get_values();
		
		if(Arr::get($values, 'send_email') AND $this->_email)
		{
			return Email::send($this->_email, $values['subject'], $values['message']);
		}
		
		return FALSE;
	}
	
}