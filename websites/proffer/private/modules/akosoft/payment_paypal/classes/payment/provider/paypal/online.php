<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Provider_PayPal_Online extends Payment_Provider {
	
	protected $_discount_allowed = TRUE;
	
	public function start_payment()
	{
		$data = $this->_module->get_payment_data();
		
		if (empty($data['paypal_quantity']))
		{
			$data['paypal_quantity'] = 1;
		}
		$paypal = new Paypal;
		$paypal->price($this->_module->get_price());
		$paypal->form('item_name', $data['title']);
		$paypal->form('item_number', $data['uid']);
		$paypal->form('custom', $this->_module->get_payment_token());
		$paypal->form('quantity', $data['quantity']);
		
		return $paypal;
	}
	
	public function check($values = NULL)
	{
		$paypal = new Paypal;
		if($paypal->validate($values))
		{
			$transaction_id = Arr::get($values, 'txn_id');
			
			$payment_model = new Model_Payment;
			$payment_model->filter_by_transaction($transaction_id);
			$payment_model->filter_by_status(Model_Payment::STATUS_NEW, '!=');
			if($payment_model->count_all())
			{
				Kohana::$log->add(Log::WARNING, 'PAYPAL: duplicate transaction (txn_id: :txn_id)', array(
					':txn_id' => $transaction_id
				));

				return FALSE;
			}
			
			if($this->_module->get_price($this) != $paypal->price())
			{
				Kohana::$log->add(Log::CRITICAL, 'PAYPAL: wrong price! (:valid_price != :invalid_price, txn_id: :txn_id)', array(
					':txn_id' => $transaction_id,
					':valid_price' => $this->_module->get_price($this),
					':invalid_price' => $paypal->price()
				));
				
				return FALSE;
			}
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function finish($values = NULL)
	{
		$transaction_id = Arr::get($values, 'txn_id');
		
		$payment_model = $this->_module->get_payment_model();
		
		//save transaction to db
		$payment_model->set_transaction($transaction_id);
		
		$status = Paypal::payment_status($values);

		if($status === Payment_Module::SUCCESS)
		{
			return $this->_module->success(FALSE);
		}
		elseif($status === Payment_Module::ERROR)
		{
			$payment_model->set_status(Model_Payment::STATUS_ERROR);
			
			return $status;
		}
		
		return NULL;
	}
	
	public function get_name()
	{
		return 'paypal_online';
	}
		
	public function get_config_path($array = TRUE)
	{
		return $array ? '[paypal][online]' : 'paypal.online';
	}
	
	public function get_label()
	{
		return ___('paypal.provider.label');
	}
	
	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_email('business', array('label' => ___('paypal.provider.settings.business')));
			
		$tab->add_html(
			'<strong>'.___('paypal.provider.settings.return').':</strong><br/>'.
			Route::url('frontend/payment/paypal/return', NULL, 'http')
		);
		
		$tab->add_html(
			'<strong>'.___('paypal.provider.settings.cancel_return').':</strong><br/>'.
			Route::url('frontend/payment/paypal/cancel_return', NULL, 'http')
		);
		
		$tab->add_html('<strong>'.___('paypal.provider.settings.ipn').':</strong><br/>'.
			Route::url('frontend/payment/paypal/ipn', NULL, 'http')
		);
		
		$tab->add_fieldset('texts', ___('paypal.provider.settings.texts.title'), array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
		
		$tab->texts->add_editor("default", array(
			"label" => ___("paypal.provider.settings.texts.default.label"), 
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('paypal.provider.settings.texts.default.placeholders.title'),
				'price'		=> ___('paypal.provider.settings.texts.default.placeholders.price'),
			),
		));

		$tab->texts->add_editor("details", array(
			"label" => ___("paypal.provider.settings.texts.details.label"), 
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('paypal.provider.settings.texts.details.placeholders.title'),
				'price'		=> ___('paypal.provider.settings.texts.details.placeholders.price'),
			),
		));
	}
	
	public function settings_module_form($form, $params)
	{
		$module = Arr::get($params, 'module');
		$place = Arr::get($params, 'place');
		$module_title = Arr::get($params, 'title');
		$types = Arr::get($params, 'types');
		
		$config_path = $this->get_config_path(FALSE);
		$config_path = $module.".payment.{$config_path}.$place";
		
		$prices_tab = $form->add_tab("paypal_prices", ___('paypal.module.title'), array(
			'get_values_path' => $config_path,
			'set_values_path' => $config_path,
		));
			
		foreach($types as $type)
		{
			$account_fs = $prices_tab->add_collection($this->get_name()."-account-".$place.'-'.$type, array(
				'get_values_path' => $type,
				'set_values_path' => $type,
			));
			
			$account_fs->add_input_text("price", array(
				"label" => ___('paypal.module.price.label', array(
					':title' => $module_title[$type],
				)),
			))
				->add_validator("price", "Bform_Validator_Numeric")
				->add_filter("price", "Bform_Filter_Float");
		}
	}
	
	public function get_currency_type()
	{
		return 'paypal';
	}
	
}
