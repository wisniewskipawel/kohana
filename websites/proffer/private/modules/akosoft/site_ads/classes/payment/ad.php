<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Ad extends Payment_Module {
	
	protected $_invoice_enabled = TRUE;
	
	public function is_enabled($type = NULL)
	{
		if($this->_object)
		{
			if(Kohana::$config->load('modules.'.$this->get_module_name().'.payment.'.$this->place().'.'.($type ? $type : $this->get_type()).'.disabled'))
				return FALSE;
		}
		
		return !Kohana::$config->load(
				'modules.'.$this->get_module_name().'.payment.'.$this->place().'.default.disabled'
		);
	}
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = new Model_Ad($this->_id);
			$this->place('ad_'.$this->_object->ad_type);
		}
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
		return ___('ads.payments.ad.title');
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___('ads.payments.ad.description', array(
				':id' => $this->_object->pk(),
			)),
			'quantity' => 1,
			'uid' => 'ads|'.$this->_object->pk()
		);
		
		return $data;
	}
	
	public function success($user_context = TRUE)
	{
		if($result = parent::success($user_context))
		{
			$this->_object->pay();
			
			if($user_context)
			{
				FlashInfo::add(___('ads.add_text.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'site_ads';
	}
	
	public function get_payment_module_name()
	{
		return 'ad';
	}
	
	public function get_type()
	{
		return Arr::get($this->get_params(), 'availability_span');
	}
}