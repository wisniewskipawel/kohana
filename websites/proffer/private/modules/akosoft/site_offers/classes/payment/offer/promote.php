<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Offer_Promote extends Payment_Module {
	
	protected $_invoice_enabled = TRUE;
	
	protected $_place = 'promote';
	
	protected $_providers_enabled_group = FALSE;
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = new Model_Offer($this->_id);
		}
	}
	
	public function is_valid()
	{
		if(!parent::is_valid())
			return FALSE;
		
		if(!$this->_object->loaded())
			return FALSE;
		
		if(empty($this->_params['distinction']))
			return FALSE;
		
		if(!Arr::get(offers::distinctions(), $this->_params['distinction'], FALSE))
			return FALSE;
		
		//TODO check method, availability, owner check
		
		return TRUE;
	}
	
	public function get_title()
	{
		return ___('offers.payments.offer_promote.title');
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___('offers.payments.offer_promote.description', array(
				':offer_title' => HTML::chars($this->_object->offer_title),
				':distinction' => Arr::get(offers::distinctions(), $this->_params['distinction']),
			)),
			'quantity' => 1,
			'uid' => 'offer|'.$this->_object->pk()
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return Route::get('site_offers/frontend/offers/show')->uri(array(
						'offer_id' => $this->_object->pk(), 
						'title' => URL::title($this->_object->offer_title)
				)).URL::query(array('preview' => 'true'), FALSE);
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
			$this->_object->promote(array(
				'offer_distinction'   => $this->_params['distinction']
			), TRUE);
			
			if($user_context)
			{
				FlashInfo::add(___('offers.promote.success'));
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
		return 'offer_promote';
	}
	
	public function get_type()
	{
		return offers::payment_place($this->_params['distinction']);
	}
	
}
