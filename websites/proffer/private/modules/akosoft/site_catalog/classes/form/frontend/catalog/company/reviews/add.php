<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Catalog_Company_Reviews_Add extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'catalog.reviews');
		
		$this->add_input_email('email');
		
		$this->add_rating('rating');
		
		$this->add_textarea('comment_body', array('required' => FALSE, 'chars_counter' => 1000))
			->add_validator('comment_body', 'Bform_Validator_Html')
			->add_validator('comment_body', 'Bform_Validator_Length', array('max' => 1000));
		
		$this->add_input_text('comment_author', array('required' => FALSE))
			->add_validator('comment_author', 'Bform_Validator_Length', array('max' => 32))
			->add_validator('comment_author', 'Bform_Validator_Html');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.save'));
		
		$this->template('site');
	}
	
}
