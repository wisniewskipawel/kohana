<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Catalog_SendMessage extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->add_input_email('email', array('label' => 'forms.contact.email'));
		
		$this->add_input_text('subject', array('label' => 'forms.contact.subject'))
			->add_validator('subject', 'Bform_Validator_Html');
		
		$this->add_textarea('message', array('label' => 'forms.contact.message'))
			->add_validator('message', 'Bform_Validator_Html');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));
		
		$this->template('site');
	}
	
}
