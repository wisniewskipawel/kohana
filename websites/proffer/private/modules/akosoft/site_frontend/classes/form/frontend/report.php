<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Frontend_Report extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$current_user = Arr::get($params, 'current_user');
		
		$this->param('i18n_namespace', 'forms.report');
		
		$this->add_input_email('email', array(
			'value' => $current_user ? $current_user->get_email_address() : NULL,
		));
		
		$this->add_textarea('reason');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));
		
		$this->template('site');
	}
	
}
