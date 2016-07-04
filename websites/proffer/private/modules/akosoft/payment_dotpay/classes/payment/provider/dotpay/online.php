<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Provider_Dotpay_Online extends Payment_Provider {
	
	protected $_invoice_enabled = TRUE;
	
	public function init()
	{
		if(!$this->config('client_id'))
		{
			throw new Kohana_Exception('Please configure DotPay Online!');
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
			$this->_module->set_invoice($form->has('invoice') && $form->invoice->get_value());
			$result = $this->_module->success(TRUE);
			
			HTTP::redirect($this->_module->redirect_url($result));
			
			return NULL;
		}
		return $form->render();
	}
	
	public function get_name()
	{
		return 'dotpay_online';
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '[dotpay][online]' : 'dotpay.online';
	}
	
	public function get_label()
	{
		return ___('dotpay.online.title');
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
			$type = $type ? $type : $this->_module->get_type();
			
			$text = str_replace('%client_id%', $this->config('client_id'), $text);
			$text = str_replace('%service_id%', $this->_module->config('service_id', $type), $text);
			$text = str_replace(
				'%link%', 
				HTML::anchor(
					'https://ssl.dotpay.pl/?id='.$this->config('client_id').'&code='.$this->_module->config('service_id', $type),
					___('dotpay.online.buy_link'),
					array(
						'target' => '_blank',
					)
				), 
				$text);
		}
		
		return $text;
	}

	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_text('client_id', array('label' => ___('dotpay.online.client_id')))
			->add_validator('client_id', 'Bform_Validator_Integer');
		
		$tab->add_bool('delete_codes', array('label' => ___('dotpay.online.delete_codes')));
		
		$dotpay_texts = $tab->add_fieldset('dotpay_texts', ___('dotpay.online.texts.title'), array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
			
		$dotpay_texts->add_editor('default', array(
			"label" => ___("dotpay.online.texts.default.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('dotpay.online.texts.default.placeholders.title'),
				'price'		=> ___('dotpay.online.texts.default.placeholders.price'),
				'link'			=> ___('dotpay.online.texts.default.placeholders.link'),
				'service_id'	=> ___('dotpay.online.texts.default.placeholders.service_id'),
				'client_id'		=> ___('dotpay.online.texts.default.placeholders.client_id'),
			),
		));

		$dotpay_texts->add_editor('details', array(
			"label" => ___("dotpay.online.texts.details.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('dotpay.online.texts.details.placeholders.title'),
				'price'		=> ___('dotpay.online.texts.details.placeholders.price'),
				'link'			=> ___('dotpay.online.texts.details.placeholders.link'),
				'service_id'	=> ___('dotpay.online.texts.details.placeholders.service_id'),
				'client_id'		=> ___('dotpay.online.texts.details.placeholders.client_id'),
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

		$dotpay_accounts = $form->add_tab($this->get_name()."-accounts", ___('dotpay.online.payment.accounts'), array(
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
				"label" => ___('dotpay.online.payment.service_id', array(
					':title' => $module_title[$type],
				)),
			));
			
			$account_fs->add_input_text("price", array(
				"label" => ___('dotpay.online.payment.price', array(
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
