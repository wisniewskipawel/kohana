<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Product_Order extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'products.forms.order');
		
		$this->add_input_text('quantity', array('value' => 1))
			->add_validator('quantity', 'Bform_Validator_HTML');
		
		$this->add_group_radio('person_type', array(
			'private' => ___('products.forms.order.person_type_values.private'), 
			'company' => ___('products.forms.order.person_type_values.company'),
		));
		
		$this->add_input_text('name', array('required' => $this->form_data('person_type') != 'company'))
			->add_validator('name', 'Bform_Validator_HTML');
		
		$this->add_input_text('company_name', array('required' => $this->form_data('person_type') != 'private'))
			->add_validator('company_name', 'Bform_Validator_HTML');
		
		$this->add_input_text('company_nip', array('required' => $this->form_data('person_type') != 'private'))
			->add_validator('company_nip', 'Bform_Validator_HTML');
		
		$this->add_input_email('email', array('label' => 'email'));
		
		$this->add_input_text('phone', array('label' => 'telephone'))
			->add_validator('phone', 'Bform_Validator_HTML');
		
		$this->add_input_text('street', array('label' => 'street'))
			->add_validator('street', 'Bform_Validator_HTML');
		
		$this->add_input_text('postal_code', array('label' => 'postal_code'))
			->add_validator('postal_code', 'Bform_Validator_HTML');
		
		$this->add_input_text('city', array('label' => 'city'))
			->add_validator('city', 'Bform_Validator_HTML');
		
		$this->add_textarea('remarks', array('required' => FALSE))
			->add_validator('remarks', 'Bform_Validator_HTML');
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));
	}
	
}