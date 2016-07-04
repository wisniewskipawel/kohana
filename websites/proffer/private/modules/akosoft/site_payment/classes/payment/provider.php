<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Payment_Provider {
	
	protected $_module;
	
	protected $_invoice_enabled = FALSE;
	
	protected $_config = NULL;
	
	protected $_discount_allowed = FALSE;
	
	public function __construct()
	{
		$this->_config = Kohana::$config->load('global.payment.'.$this->get_config_path(FALSE));
	}
	
	public function is_enabled($module = NULL, $module_place = NULL, $type = NULL)
	{
		if(!Kohana::$config->load('global.payment.'.$this->get_config_path(FALSE).'.enabled'))
			return FALSE;
		
		if($module)
		{
			if($module instanceof Payment_Module)
			{
				$module_place = $module->place();
				$module = $module->get_module_name();
			}
			
			$config_path = 'modules.'.$module.'.payment.'.
				$this->get_config_path(FALSE).'.'.$module_place;
			
			if($type)
			{
				$config_path .= '.'.$type;
			}
			
			if(!Kohana::$config->load($config_path.'.enabled'))
				return FALSE;
		}
		
		return TRUE;
	}
	
	public function set_module(Payment_Module $module)
	{
		$this->_module = $module;
	}
	
	public function init()
	{
		
	}
	
	public function start_payment()
	{
		
	}
	
	public function check($values = NULL)
	{
		
	}
	
	public function finish()
	{
		
	}
	
	public function get_name()
	{
		
	}
	
	public function get_price($type, Payment_Module $payment_module = NULL)
	{
		if(!$payment_module)
		{
			$payment_module = $this->_module;
		}
		
		$payment_module->provider($this);
		
		return $payment_module->config('price', $type);
	}
	
	public function get_currency_type()
	{
		return 'short';
	}
	
	public function get_label()
	{
		return $this->get_name();
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '['.$this->get_name().']' : $this->get_name();
	}
	
	public function get_text($text_type = 'default', $type = NULL)
	{
		if(!$this->_module)
		{
			throw new Kohana_Exception('Payment Module is not set for this provider!');
		}
		
		$type = $type ? $type : $this->_module->get_type();
		
		if($text = $this->config('texts.'.$text_type))
		{
			$text = str_replace('%title%', $this->_module->get_title(), $text);
			return str_replace('%price%', $this->_module->show_price($this, $type), $text);
		}
		
		return NULL;
	}
	
	public function is_invoice_enabled()
	{
		return $this->_invoice_enabled;
	}
	
	public function settings_provider_form($form)
	{
		
	}
	
	public function settings_module_form($form, $params)
	{
		
	}
	
	public function config($path)
	{
		return Arr::path($this->_config, $path);
	}
	
	public function is_discount_allowed()
	{
		return $this->_discount_allowed;
	}
}