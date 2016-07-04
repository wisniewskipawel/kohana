<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Notifier_Edit extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->form_data($params['notifier']->as_array());
		
		$this->add_input_text('notify_email', array('label' => 'email'));
		$this->add_bool('status', array('label' => 'notifiers.forms.status.active', 'required' => FALSE));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
