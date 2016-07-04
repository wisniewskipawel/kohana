<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Catalog_Company_Send extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->param('i18n_namespace', 'catalog.forms.company_send');
		
		$this->add_input_email('email', array('label' => 'email'));
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));

		$this->template('site');
	}
	
}