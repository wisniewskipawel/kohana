<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Provider_Dotpay_SMS extends Payment_Provider {
	
	public function init()
	{
		if(!$this->config('client_id'))
		{
			throw new Kohana_Exception('Please configure DotPay SMS!');
		}

		parent::init();
	}
	
	public function start_payment()
	{
		$data = $this->_module->get_payment_data();
		
		$data['dotpay_account'] = $this->_module->config('service_id');
		$data['provider_type'] = $this->get_name();
		$data['payment_module'] = $this->_module;
		$data['provider'] = $this;
		
		$form = Bform::factory('Frontend_Payment_Dotpay', $data);

		if ($form->validate())
		{
			$result = $this->_module->success(TRUE);
			
			HTTP::redirect($this->_module->redirect_url($result));
			
			return NULL;
		}
		return $form->render();
	}
	
	public function get_name()
	{
		return 'dotpay_sms';
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '[dotpay][sms]' : 'dotpay.sms';
	}
	
	public function get_label()
	{
		return ___('dotpay.sms.title');
	}
	
	public function check_code($service_id, $code)
	{
		return dotpay::check_code($service_id, $code, $this->config('client_id'), $this->config('delete_codes'));
	}
	
	public function get_text($text_type = 'default', $type = NULL)
	{
		$text = parent::get_text($text_type, $type);
			
		if($text)
		{
			$text = str_replace('%client_id%', $this->config('client_id'), $text);
			$text = str_replace('%service_id%', $this->_module->config('service_id', $type), $text);
			$text = str_replace('%konektor%', $this->_module->config('konektor', $type), $text);
		}
		
		return $text;
	}

	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_text('client_id', array('label' => ___('dotpay.sms.client_id')))
			->add_validator('client_id', 'Bform_Validator_Integer');
		
		$tab->add_bool('delete_codes', array('label' => ___('dotpay.sms.delete_codes')));
		
		$dotpay_texts = $tab->add_fieldset('dotpay_texts', ___('dotpay.sms.texts.title'), array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
		
		$dotpay_texts->add_editor('default', array(
			"label" => ___("dotpay.sms.texts.default.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('dotpay.sms.texts.default.placeholders.title'),
				'price'		=> ___('dotpay.sms.texts.default.placeholders.price'),
				'service_id'	=> ___('dotpay.sms.texts.default.placeholders.service_id'),
				'konektor'		=> ___('dotpay.sms.texts.default.placeholders.konektor'),
				'client_id'		=> ___('dotpay.sms.texts.default.placeholders.client_id'),
			),
		));

		$dotpay_texts->add_editor('details', array(
			"label" => ___("dotpay.sms.texts.details.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('dotpay.sms.texts.details.placeholders.title'),
				'price'		=> ___('dotpay.sms.texts.details.placeholders.price'),
				'service_id'	=> ___('dotpay.sms.texts.details.placeholders.service_id'),
				'konektor'		=> ___('dotpay.sms.texts.details.placeholders.konektor'),
				'client_id'		=> ___('dotpay.sms.texts.details.placeholders.client_id'),
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
		
		$dotpay_accounts = $form->add_tab($this->get_name()."-accounts", ___('dotpay.sms.payment.accounts'), array(
			'get_values_path' => $config_path,
			'set_values_path' => $config_path,
		));
		
		foreach($types as $type)
		{
			$account_fs = $dotpay_accounts->add_fieldset($this->get_name()."-account-".$place.'-'.$type, $module_title[$type], array(
				'get_values_path' => $type,
				'set_values_path' => $type,
			));
			
			$account_fs->add_input_text("service_id", array(
				"label" => ___('dotpay.sms.payment.service_id', array(
					':title' => $module_title[$type],
				)),
			));
			
			$account_fs->add_input_text("price", array(
				"label" => ___('dotpay.sms.payment.price', array(
					':title' => $module_title[$type],
				)),
			));
			
			$account_fs->add_input_text("konektor", array(
				"label" => ___('dotpay.sms.payment.konektor', array(
					':title' => $module_title[$type],
				)),
			));
		}
	}
	
	public function get_currency_type()
	{
		return 'dotpay';
	}
	
}
