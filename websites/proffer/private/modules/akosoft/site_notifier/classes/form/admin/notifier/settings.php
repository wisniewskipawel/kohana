<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Notifier_Settings extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'notifiers.forms.settings');
		
		$this->form_data($params);
		
		$this->add_bool('send_confirmation', array(
			'required' => FALSE,
		));
		
		$this->add_input_submit(___('form.save'));
	}
	
}