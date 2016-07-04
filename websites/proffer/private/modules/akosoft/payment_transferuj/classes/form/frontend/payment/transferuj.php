<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Frontend_Payment_Transferuj extends Bform_Form {
	
	public function create(array $params = array())
	{
		$provider = $params['provider'];
		
		$payment_module = $params['payment_module'];
		$payment_data = $payment_module->get_payment_data();
		
		$this->param('action', 'https://secure.transferuj.pl');
		
		$price = number_format($payment_module->get_price(), 2, '.', '');
		$token = $payment_module->get_payment_token();
		
		$this->add_input_hidden('id', $provider->config('client_id'));
		$this->add_input_hidden('kwota', $price);
		$this->add_input_hidden('opis', $payment_data['title']);
		$this->add_input_hidden('crc', $token);
		
		$this->add_input_hidden('wyn_url', Route::url('transferuj/bridge', NULL, 'http'));
		
		$this->add_input_hidden('pow_url', Route::url('transferuj/return/success', NULL, 'http').'?token='.$token);
		$this->add_input_hidden('pow_url_blad', Route::url('transferuj/return/error', NULL, 'http').'?token='.$token);
		
		$this->add_input_hidden('md5sum', md5(
			$provider->config('client_id').
			$price.
			$token.
			$provider->config('security_code')
		));
		
		$this->add_input_submit(___('transferuj.forms.payment.submit'));
		
		$this->template('site');
	}
	
}
