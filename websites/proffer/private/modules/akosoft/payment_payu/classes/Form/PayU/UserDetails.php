<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Form_PayU_UserDetails extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->form_data($params);
		
		$this->param('i18n_namespace', 'payu.forms.userdetails');
		
		$this->add_input_text('first_name')
			->add_validator('first_name', 'Bform_Validator_HTML');
		
		$this->add_input_text('last_name')
			->add_validator('last_name', 'Bform_Validator_HTML');
		
		$this->add_input_email('email');
		
		$this->add_input_submit(___('form.next'));
	}
	
}