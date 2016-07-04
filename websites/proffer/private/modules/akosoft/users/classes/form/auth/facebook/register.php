<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Auth_Facebook_Register extends BForm_Form {
	
	public function create(array $params = array())
	{
		$user_info = $params['user_info'];
		
		$this->add_input_text('user_name', array('value' => Arr::get((array)$user_info, 'username')))
			->add_validator('user_name', 'Bform_Validator_Auth_Username');
			
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
