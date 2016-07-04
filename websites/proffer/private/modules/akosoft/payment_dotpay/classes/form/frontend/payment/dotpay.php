<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Payment_Dotpay extends Bform_Form {
	
	public function create(array $params = array())
	{
		$payment_module = $params['payment_module'];
		
		$this->add_input_text('code', array('label' => 'dotpay.forms.pay.code'))
			->add_validator('code', 'Bform_Validator_Payment_Dotpay_Code', array(
				'account' => $params['dotpay_account'], 
				'provider' => $params['provider'],
			));
		
		if($payment_module->is_invoice_enabled())
		{
			$this->add_bool('invoice', array('label' => 'payments.forms.invoice'));
		}
		
		$this->add_input_submit(___('dotpay.forms.submit'));

		$this->template('site');
	}
	
}
