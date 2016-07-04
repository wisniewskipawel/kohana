<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Contact extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'forms.contact');
		
		$this->add_input_email('email');
		
		$this->add_input_text('subject')
			->add_validator('subject', 'Bform_Validator_Html');
		
		$this->add_textarea('message')
			->add_validator('message', 'Bform_Validator_Html');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));
		
		$this->template('site');
		
	}
	
}
