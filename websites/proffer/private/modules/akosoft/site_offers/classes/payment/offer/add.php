<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Payment_Offer_Add extends Payment_Module {
	
	protected $_place = 'offer_add';
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = new Model_Offer($this->object_id());
		}
	}
	
	public function is_enabled($type = NULL)
	{
		$type = ($type !== NULL ? $type : $this->get_type());
		
		if($this->object() AND $this->object()->loaded())
		{
			if($this->object()->is_paid())
				return FALSE;
		}
		
		$enabled_type = Kohana::$config->load('modules.'.$this->get_module_name().'.payment.'.$this->place().'.'.$type.'.enabled');
		
		if(!$enabled_type)
			return FALSE;
		
		if($this->_auth->is_logged())
		{
			if($enabled_type == 2)
				return FALSE;
		}
			
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
		if(!parent::is_valid())
			return FALSE;
		
		if(!$this->_object->loaded())
			return FALSE;
		
		//TODO check method, availability, owner check
		
		return TRUE;
	}
	
	public function get_title()
	{
		return ___('offers.payments.'.$this->get_payment_module_name().'.title');
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___('offers.payments.'.$this->get_payment_module_name().'.description', array(
				':offer_title' => HTML::chars($this->_object->offer_title),
			)),
			'quantity' => 1,
			'uid' => $this->get_payment_module_name().'|'.$this->_object->pk(),
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return offers::uri($this->_object).URL::query(array('preview' => 'true'), FALSE);
		}
		else
		{
			return parent::redirect_url($type);
		}
	}
	
	public function success($user_context = TRUE)
	{
		if($result = parent::success($user_context))
		{
			$this->_object->set_paid();
			
			if($user_context)
			{
				FlashInfo::add(___('offers.add.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'site_offers';
	}
	
	public function get_payment_module_name()
	{
		return 'offer_add';
	}
	
}
