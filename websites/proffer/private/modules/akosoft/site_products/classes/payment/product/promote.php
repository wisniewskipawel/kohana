<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Product_Promote extends Payment_Module {
	
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
			$this->_object = new Model_Product($this->_id);
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
		
		if(!Arr::get(products::distinctions(), $this->_params['distinction'], FALSE))
			return FALSE;
		
		//TODO check method, availability, owner check
		
		return TRUE;
	}
	
	public function get_title()
	{
		return ___('products.payments.product_promote.title');
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___('products.payments.product_promote.description', array(
				':product_title'	=> HTML::chars($this->_object->product_title),
				':distinction'	=> Arr::get(products::distinctions(), $this->_params['distinction']),
			)),
			'quantity' => 1,
			'uid' => 'product|'.$this->_object->pk()
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return products::uri($this->_object).URL::query(array('preview' => 'true'), FALSE);
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
				'product_distinction'   => $this->_params['distinction']
			));
			
			if($user_context)
			{
				FlashInfo::add(___('products.promote.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'site_products';
	}
	
	public function get_payment_module_name()
	{
		return 'product_promote';
	}
	
	public function get_type()
	{
		return $this->_params['distinction'];
	}
	
	public function types()
	{
		return Products::distinctions(FALSE);
	}
	
}
