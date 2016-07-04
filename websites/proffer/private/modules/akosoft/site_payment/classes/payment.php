<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class payment {
	
	protected static $_modules = array();
	
	protected static $_providers = array();

	public static function register_module($module, $class_name = NULL)
 	{
		if(!$class_name)
 		{
			$class_name = 'Payment_'.$module;
		}
		
		if(class_exists($class_name))
		{
			self::$_modules[$module] = $class_name;
 			return TRUE;
 		}
 
 		Kohana::$log->add(
 				Log::ERROR, 
				'PAYMENT: cannot register module :module! Class :class not exists!', 
 				array(
 					':module' => $module,
					':class' => $class_name,
 				)
 			)->write();

		return FALSE;
	}
	
	public static function is_registered_module($module)
	{
		return array_key_exists($module, self::$_modules);
	}

	/**
	 * Get module instance.
	 * 
	 * @param type $module
	 * @param type $payment_method
	 * @param type $id
	 * @return Payment_Module instance of payment module
	 */
	public static function module_init($module, $payment_method, $id)
	{
		$instance = self::load_payment_module($module);
		
		if($instance)
		{
			$instance->init($payment_method, $id);

			return $instance;
		}
		
		return NULL;
	}
	
	/**
	 * Get module instance form payment model or id of payment
	 * 
	 * @param mixed $payment Model_Payment object or id of payment in DB
	 * @return Payment_Module instance of payment module
	 */
	public static function module_from_payment($payment)
	{
		if(!$payment instanceof Model_Payment)
		{
			$payment = new Model_Payment((int)$payment);
		}
		
		if(!$payment->loaded())
		{
			throw new Kohana_Exception('Model Payment is not loaded!');
		}
		
		$instance = self::load_payment_module($payment->module, $payment);
		
		if($instance)
		{
			return $instance;
		}
		
		return NULL;
	}
	
	/**
	 * Load payment module.
	 * 
	 * @param string $module
	 * @param Model_Payment $payment
	 * @return Payment_Module
	 * @throws Kohana_Exception
	 */
	public static function load_payment_module($module = NULL, $payment = NULL)
	{
		if(!$module && !$payment)
		{
			throw new Kohana_Exception('Cannot load this payment module!');
		}
		
		if(!$module && $payment && $payment instanceof Model_Payment && $payment->loaded())
		{
			$module = $payment->module;
		}
		
		if(self::is_registered_module($module))
 		{
			$class_name = self::$_modules[$module];
 			$instance = new $class_name($payment);
 			
			return $instance;
 		}
		
		throw new Kohana_Exception(
			'Cannot load payment module ":module"! Module is not registered!',
			array(':module' => $module)
		);
	}
	
	public static function register_provider($provider_name)
	{
		if(class_exists('Payment_Provider_'.$provider_name))
		{
			self::$_providers[$provider_name] = NULL;
			
			return TRUE;
		}

		Kohana::$log->add(
				Log::ERROR, 
				'PAYMENT: cannot register provider :name', 
				array(
					':name' => $provider_name,
				)
			)->write();

		return FALSE;
	}
	
	public static function load_provider($provider_name)
	{
		if(self::is_registered_provider($provider_name))
		{
			if(self::$_providers[$provider_name] === NULL)
			{
				$class_name = 'Payment_Provider_'.$provider_name;
				$instance = new $class_name();
				
				self::$_providers[$provider_name] = $instance;
			}
			
			return self::$_providers[$provider_name];
		}
		
		throw new Kohana_Exception(
			'Cannot load payment provider ":name"! Module is not registered!',
			array(':name' => $provider_name)
		);
	}
	
	public static function is_registered_provider($provider_name)
	{
		return array_key_exists($provider_name, self::$_providers);
	}
	
	public static function get_providers($load = TRUE)
	{
		if($load)
		{
			foreach(self::$_providers as $provider_name => $provider)
			{
				if(!($provider instanceof Payment_Provider))
				{
					self::load_provider($provider_name);
				}
			}
		}
		
		return self::$_providers;
	}

	public static function get_global($only_enabled = FALSE)
	{
		$config = Kohana::$config->load('global.payment');
		$services = array();
		$types = array();
		foreach ($config as $service => $array)
		{
			$tmp = array('label' => $array['label'], 'enabled' => $array['enabled']);
			
			if ($only_enabled AND $array['enabled'])
			{
				$services[$service] = $tmp;
			}
			elseif ($only_enabled === FALSE)
			{
				$services[$service] = $tmp;
			}
		}
		foreach ($services as $name => $array)
		{
			$types = Kohana::$config->load('global.payment.' . $name . '.types');
			foreach ($types as $type => $value)
			{
				if (empty($services[$name]['types']))
				{
					$services[$name]['types'] = array();
				}
				
				$tmp = array('label' => $value['label'], 'enabled' => $value['enabled']);
				
				if ($only_enabled AND $value['enabled'])
				{
					$services[$name]['types'][$type] = $tmp;
				}
				elseif ($only_enabled === FALSE)
				{
					$services[$name]['types'][$type] = $tmp;
				}
			}
		}
		asort($services);
		return $services;
	}
	
	public static function enabled($module_name, $payment_method, $place)
	{
		if ($module_name != 'global' AND ! self::enabled('global', $payment_method, $place))
		{
			//return FALSE;
		}
		$payment_method = str_replace('_', '.', $payment_method);
		if ($module_name == 'global')
		{
			list($service, $type) = explode('.', $payment_method);
			$result = Kohana::$config->load("global.payment.$service.types.$type.enabled");
		}
		else
		{
			if ( ! empty($_POST))
			{
				if (Arr::path($_POST, "$module_name.payment.$payment_method.$place.enabled", NULL) !== NULL)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			$result = Kohana::$config->load("modules.$module_name.payment.$payment_method.$place.enabled");
		}
		return (bool) $result;
	}
	
	public static function get_module($module_name, $place, $only_enabled)
	{
		$all = self::get_global();
		
		foreach ($all as $service_name => $array)
		{
			if ( ! $array['enabled'] AND $only_enabled)
			{
				unset($all[$service_name]);
				continue;
			}
			
			foreach ($array['types'] as $type => $array2)
			{
				if ( ! $array2['enabled'] AND $only_enabled)
				{
					unset($all[$service_name]['types'][$type]);
					continue;
				}
				
				$config = Kohana::$config->load("modules.$module_name.payment");
				
				if ( ! empty($config[$service_name][$type][$place]))
				{
					if ( ($only_enabled AND ! $config[$service_name][$type][$place]['enabled']) )
					{
						unset($all[$service_name]['types'][$type]);
					}
				}
				else
				{
					unset($all[$service_name]['types'][$type]);
				}
			}
			
			if (empty($all[$service_name]['types']))
			{
				unset($all[$service_name]);
			}
		}
		return $all;
	}
	
	public static function get_form($payments, $type = NULL)
	{
		$result = array();
		
		if($payments instanceof Payment_Module)
		{
			$providers = $payments->get_providers($type);
			
			if(!$providers)
			{
				return array();
			}
			
			foreach($providers as $provider)
			{
				$result[$provider->get_name()] = $provider->get_label();
			}
		}
		else
		{
			foreach ($payments as $service => $array)
			{
				foreach ($array['types'] as $type => $array2)
				{
					$result[$service . '_' . $type] = $array2['label'];
				}
			}
		}
		
		return $result;
	}
	
	public static function get_text($provider, $payment_module, $type, $text_type = 'default')
	{
		$provider = $provider instanceof Payment_Provider ? $provider : self::load_provider($provider);
		
		$payment_module = $payment_module instanceof Payment_Module ? 
			$payment_module : self::load_payment_module($payment_module);
		
		if($provider)
		{
			return $provider->get_text($payment_module, $type, $text_type = 'default');
		}
		
		return FALSE;
	}
	
	public static function currency($type = 'default')
	{
		return Kohana::$config->load('payment.currency.'.$type);
	}
	
	public static function price_format($price, $unit = TRUE)
	{
		$price = number_format((float)$price, 2, ',', ' ');
		
		$price_parts = explode(',', $price);
		
		if($price_parts[1] == '00')
		{
			$price = $price_parts[0];
		}
		
		if($unit)
		{
			if($unit === TRUE)
			{
				$unit = 'short';
			}
			
			$price .= ' '.self::currency($unit);
		}
		
		return $price;
	}
}
