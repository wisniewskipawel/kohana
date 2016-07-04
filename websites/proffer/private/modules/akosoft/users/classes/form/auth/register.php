<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_Register extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->add_input_text('user_name')
			->add_validator('user_name', 'Bform_Validator_Auth_Username');
		
		$this->add_input_email('user_email')
			->add_validator('user_email', 'Bform_Validator_Auth_Email');
		
		$this->add_input_password('user_pass', array('required' => TRUE, 'class' => 'password', 'strength' => TRUE))
			->add_validator('user_pass', 'Bform_Validator_Html');
		
		$this->add_input_password('user_pass2', array('required' => TRUE, 'class' => 'password'))
			->add_validator('user_pass', 'Bform_Validator_Compare', array('msg' => ___('users.forms.confirm_pass.error.compare'), 'compare' => 'user_pass2'));
		
		$this->add_captcha('captcha');
			
		$this->add_agreements('agreements');
		
		$payment_module = $params['payment_module'];
		
		if($payment_module->is_enabled())
		{
			$payment_methods = payment::get_form($payment_module);
			$this->add_group_radio('payment_method', $payment_methods, array('label' => 'payments.forms.payment_method.label', 'row_class' => 'payment_method_group'));
			
			$this->add_html('<div id="payment-info"></div>', array(
				'label' => 'payments.forms.payment_info', 
				'row_id' => 'payment-info-row',
				'no_decorate' => FALSE,
			));
		}
		
		$this->add_input_submit(___('users.register.btn'));
		
		$this->template('site');
	}   
}
