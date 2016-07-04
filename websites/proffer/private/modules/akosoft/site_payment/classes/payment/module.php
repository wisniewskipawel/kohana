<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Payment_Module {
	
	const ERROR	 = 0;
	const SUCCESS = 1;
	const INVOICE = 2;
	const PENDING = 3;
	
	protected $_id = NULL;
	
	protected $_object = NULL;
	
	protected $_provider = NULL;
	
	protected $_payment = NULL;
	
	protected $_place = NULL;
	
	protected $_params = NULL;
	
	protected $_invoice_enabled = FALSE;
	
	protected $_logged_only = FALSE;
		
	protected $_auth = NULL;
	
	protected $_user = NULL;
	
	protected $_providers_enabled_group = TRUE;
	
	protected $_discount = FALSE;
	
	protected $_is_discount_allowed = FALSE;
	
	public function __construct($payment = NULL)
	{
		$this->_auth = BAuth::instance();
		$this->_user = $this->_auth->get_user();
		
		$this->_payment = $payment ? $payment : new Model_Payment;
		
		if($this->_payment instanceof Model_Payment && $this->_payment->loaded())
		{
			$this->_provider = payment::load_provider($this->_payment->method);
			$this->object_id($this->_payment->object_id);
			$this->_params = (array)$this->_payment->params;
			
			$this->load_object();
		}
	}
	
	public function new_payment($provider, $id) 
	{
		$this->provider($provider);
		$this->_id = (int)$id;
		
		$this->load_object();
		
		if($this->is_discount_allowed() AND !empty($this->_params['discount']))
		{
			$this->discount(TRUE);
		}
		
		$this->_params['discount'] = $this->discount();
		$this->_params['total_price'] = $this->get_price();
		
		//save info to model
		$this->_payment->init_payment($this);
		
		if($this->is_valid())
		{
			if($this->is_enabled())
			{
				$this->_provider->set_module($this);
				$this->_provider->init();
				return TRUE;
			}
		}
		else
		{
			throw new Kohana_Exception('PAYMENT: module :module is not valid! (method: :method, id: :id)',
					array(
						':module' => $this->get_module_name(), 
						':method' => $this->_provider->get_name(), 
						':id' => $this->_id
					));
		}
		
		return FALSE;
	}
	
	public function start_payment()
	{
		if($this->is_enabled())
		{
			$this->_provider->set_module($this);
			
			if($this->get_price())
			{
				return $this->_provider->start_payment();
			}
			else
			{
				//is free - success!
				$this->pay(NULL, TRUE);
			}
		}
		else
		{
			$this->pay(NULL, TRUE);
		}
		
		return NULL;
	}
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			$this->_object = $object;
		}
	}
	
	public function object()
	{
		return $this->_object;
	}
	
	public function object_id($set_id = NULL)
	{
		if($set_id)
		{
			$this->_id = $set_id;
		}
		
		return $this->_id;
	}
	
	public function is_enabled($type = NULL)
	{
		$type = ($type !== NULL ? $type : $this->get_type());
		
		if(Kohana::$config->load('modules.'.$this->get_module_name().'.payment.'.$this->place().'.'.$type.'.disabled'))
			return FALSE;
			
		$registered_providers = payment::get_providers(TRUE);
		
		foreach($registered_providers as $provider)
		{
			if($provider->is_enabled($this->get_module_name(), $this->place(), $this->_providers_enabled_group ? FALSE : $type))
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function is_valid() 
	{
		if(!$this->_payment->loaded())
			return FALSE;
		
		if(!($this->_provider instanceof Payment_Provider))
			return FALSE;
		
		if($this->_logged_only)
		{
			if(!$this->_auth->is_logged() || !$this->_user || !$this->_user->loaded())
				return FALSE;
		}
		
		return TRUE;
	}
	
	public function is_started()
	{
		return $this->_payment AND $this->_payment->loaded();
	}
	
	public function success($user_context = TRUE) 
	{
		if($this->_payment && $this->_payment->loaded())
		{
			$this->_payment->set_status(Model_Payment::STATUS_SUCCESS);
		}
		
		return $this->is_invoice_enabled() && $this->_payment->has_invoice() ? self::INVOICE : self::SUCCESS;
	}
	
	public function redirect_url($type)
	{
		if($type == self::INVOICE)
		{
			return Route::get('invoice/init')
				->uri(array(
					'payment_id' => $this->get_payment_token()
				));
		}
		else
		{
			return Route::get('index')->uri();
		}
	}
	
	public function get_title()
	{
		return ___($this->get_module_name().'.payments.'.$this->get_payment_module_name().'.title');
	}
	
	public function get_payment_data() {}
	
	public function get_price($payment_provider = NULL, $type = NULL) 
	{
		if($this->is_started())
		{
			return Arr::get((array)$this->get_payment_model()->params, 'total_price');
		}
		
		if(!$payment_provider)
		{
			$payment_provider = $this->provider();
		}
		
		if(!($payment_provider instanceof Payment_Provider))
		{
			throw new Kohana_Exception('You must set payment provider before call this method!');
		}
		
		$price = $payment_provider->get_price($type ? $type : $this->get_type(), $this);
		
		if($this->is_discount_allowed($type) AND $this->discount())
		{
			$price -= $price * ($this->discount() / 100);
		}
		
		return $price;
	}
	
	public function show_price($payment_provider = NULL, $type = NULL) 
	{
		if(!$payment_provider)
		{
			$payment_provider = $this->provider();
		}
		
		if(!($payment_provider instanceof Payment_Provider))
		{
			throw new Kohana_Exception('You must set payment provider before call this method!');
		}
		
		$price = $this->get_price($payment_provider, $type);
		
		return payment::price_format($price, $payment_provider->get_currency_type());
	}
	
	public function get_module_name() {}
	
	public function place($value = NULL)
	{
		if($value !== NULL)
		{
			$this->_place = $value;
		}
		
		return $this->_place;
	}
	
	public function get_type() 
	{
		return 'default';
	}
	
	public function provider(Payment_Provider $provider = NULL) 
	{
		if($provider)
		{
			$this->_provider = $provider;
			$this->_provider->set_module($this);
		}
		
		return $this->_provider;
	}
	
	public function get_method() 
	{
		return $this->_provider->get_name();
	}
	
	public function get_object_id() 
	{
		return $this->_id;
	}
	
	public function get_payment_module_name()
	{
		
	}
	
	public function get_payment_date()
	{
		return strtotime($this->_payment->date_created);
	}
	
	public function get_payment_model()
	{
		return $this->_payment;
	}
	
	public function get_payment_token()
	{
		return $this->_payment->token;
	}
	
	public function set_params($params)
	{
		$this->_params = $params;
	}
	
	public function get_params()
	{
		return $this->_params;
	}
	
	public function is_invoice_enabled()
	{
		if(!$this->_provider)
			return FALSE;
		
		return Kohana::$config->load('payment.invoice.enabled') 
			&& $this->_invoice_enabled 
			&& $this->_provider->is_invoice_enabled();
	}
	
	public function set_invoice($invoice)
	{
		$this->_payment->set_invoice($invoice);
		
		return $this;
	}
	
	public function get_user()
	{
		return $this->_user;
	}
	
	public function get_providers($type = 'default')
	{
		$type = ($type !== NULL ? $type : $this->get_type());
		
		if(!$this->is_enabled($type))
			return NULL;
		
		$registered_providers = payment::get_providers(TRUE);
		
		$providers = array();
		
		foreach($registered_providers as $provider_name => $provider)
		{
			if($provider->is_enabled($this->get_module_name(), $this->place(), $this->_providers_enabled_group ? FALSE : $type))
			{
				$providers[$provider_name] = $provider;
			}
		}
		
		return $providers;
	}
	
	public function pay($payment_method = NULL, $force = FALSE)
	{
		//TODO: dodać sprawdzanie providera
		if($this->is_enabled() && $force == FALSE)
		{
			return HTTP::redirect(
				Route::get('site_payment/frontend/payment/new_payment')
					->uri(array(
						'place' => $this->get_payment_module_name(), 
						'payment_method' => $payment_method
					)
				).URL::query($this->get_params(), FALSE)
			);
		}
		else
		{
			return HTTP::redirect(
				$this->redirect_url($this->success())
			);
		}
	}
	
	public function logged_only()
	{
		return $this->_logged_only;
	}
	
	public function config($path, $type = NULL)
	{
		$path = ($type ? $type : $this->get_type()).'.'.$path;
		
		return Kohana::$config->load('modules.'.$this->get_module_name().'.payment.'.$this->provider()->get_config_path(FALSE).'.'.$this->place().'.'.$path);
	}
	
	public function discount($set_discount = NULL)
	{
		if($set_discount)
		{
			$this->_discount = $set_discount;
		}
		
		return $this->_discount;
	}
	
	public function is_discount_allowed()
	{
		return $this->_is_discount_allowed AND $this->provider() AND $this->provider()->is_discount_allowed();
	}
	
	public function get_lowest_price($type = NULL)
	{
		$type = ($type !== NULL ? $type : $this->get_type());
		
		$providers = $this->get_providers($type);
		
		if(!$providers)
		{
			return NULL;
		}
		
		$lowest = 0;
		
		foreach($providers as $provider)
		{
			$price = $this->get_price($provider, $type);
			
			if($lowest === 0 OR $price < $lowest)
			{
				$lowest = $price;
			}
		}
		
		return $lowest;
	}
	
}