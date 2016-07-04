<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_User extends Payment_Module {
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = new Model_User($this->_id);
			$this->place('register');
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
	
	public function is_enabled($type = NULL)
	{
		$type = ($type !== NULL ? $type : $this->get_type());
		
		if(Kohana::$config->load('modules.'.$this->get_module_name().'.payment.'.$this->place().'.'.$type.'.enabled'))
		{
			$registered_providers = payment::get_providers(TRUE);

			foreach($registered_providers as $provider)
			{
				if($provider->is_enabled($this->get_module_name(), $this->place(), $this->_providers_enabled_group ? FALSE : $type))
				{
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___($this->get_module_name().'.payments.'.$this->get_payment_module_name().'.description', array(
				':user_name' => HTML::chars($this->_object->user_name),
			)),
			'quantity' => 1,
			'uid' => 'user_register|'.$this->_object->pk()
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return Route::get('bauth/frontend/auth/login')->uri();
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
			$this->_object->edit_user(array('user_is_paid' => 1, 'user_status' => Model_User::STATUS_ACTIVE));
			
			if($user_context)
			{
				FlashInfo::add(___('users.register.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'bauth';
	}
	
	public function get_payment_module_name()
	{
		return 'user';
	}
	
}
