<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Frontend_Jobs_Send extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.forms.send');
		
		$this->add_input_email('email');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));

		$this->template('site');
	}
	
}

