<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Payment_Company_Promote extends Payment_Module {
	
	protected $_invoice_enabled = TRUE;
	
	protected $_place = 'promote';
	
	protected $_type = NULL;
	
	protected $_is_discount_allowed = TRUE;
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = new Model_Catalog_Company($this->_id);
		}
	}
	
	public function is_valid()
	{
		if(!parent::is_valid())
			return FALSE;
		
		if(!$this->_object->loaded())
			return FALSE;
		
		//type check
		if(!$this->validate_type($this->type()))
			return FALSE;
		
		return TRUE;
	}
	
	public function get_title()
	{
		return ___('catalog.payments.'.$this->get_payment_module_name().'.title');
	}

	public function get_payment_data()
	{
		$promotion_type = $this->get_promotion_type();

		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___('catalog.payments.'.$this->get_payment_module_name().'.description', array(
				':company_name'	=> HTML::chars($this->_object->company_name),
				':promotion_type' => $promotion_type ? $promotion_type->get_title() : '',
			)),
			'quantity' => 1,
			'uid' => 'company_promote|'.$this->_object->pk()
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return catalog::url($this->_object);
		}
		elseif($type == self::INVOICE)
		{
			return parent::redirect_url($type);
		}
		else
		{
			return Route::get('site_catalog/home')->uri();
		}
	}
	
	public function success($user_context = TRUE)
	{
		if($result = parent::success($user_context))
		{
			$this->_object->promote();
			
			if($user_context)
			{
				FlashInfo::add(___('catalog.companies.promote.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'site_catalog';
	}
	
	public function get_payment_module_name()
	{
		return 'company_promote';
	}
	
	public function type($set_value = NULL)
	{
		if($set_value !== NULL)
		{
			$this->_type = $set_value;
		}
		else
		{
			return $this->_object && $this->_object->loaded() ? 
				$this->_object->promotion_type :  $this->_type;
		}
	}
	
	public function get_type()
	{
		return $this->type();
	}
	
	public function discount($set_discount = NULL)
	{
		if($set_discount === TRUE)
		{
			$discount = $this->get_user()->data->catalog_discount;
			
			if($discount)
			{
				$this->get_user()->data->catalog_discount = 0;
				$this->get_user()->data->save();
			}
			
			return parent::discount($discount);
		}
		
		return parent::discount($set_discount);
	}


	public function is_discount_allowed($type = NULL)
	{
		$type = $type ? $type : $this->get_type();
		
		return parent::is_discount_allowed() AND $type == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS;
	}

	/**
	 * @return Catalog_Company_Promotion_Type[]
	 */
	public function get_types()
	{
		$types_collection = new Catalog_Company_Promotion_Types();
		return $types_collection->get_promotions_enabled();
	}

	/**
	 * @param $type_id
	 * @return bool
	 */
	public function validate_type($type_id)
	{
		foreach($this->get_types() as $type)
		{
			if($type->is_type($type_id))
				return TRUE;
		}

		return FALSE;
	}

	/**
	 * @return Catalog_Company_Promotion_Type|null
	 */
	public function get_promotion_type()
	{
		foreach($this->get_types() as $type)
		{
			if($type->is_type($this->get_type()))
				return $type;
		}

		return NULL;
	}

}
