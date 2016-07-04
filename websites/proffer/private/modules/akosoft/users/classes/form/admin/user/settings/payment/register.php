<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_User_Settings_Payment_Register extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		$this->_module = payment::load_payment_module('user');
		
		parent::create(array(
			'module' => $this->_module->get_module_name(), 
			'payment_disabled' => FALSE,
			'place' => 'register', 
			'title' => ___($this->_module->get_module_name().'.payments.'.$this->_module->get_payment_module_name().'.title'),
			'values' => $params,
		));
	}
	
	protected function tab_general_top()
	{
		$payment_enabled_col = $this->general->add_collection('payment_enabled', array(
			'get_values_path' => 'register.default',
			'set_values_path' => 'register.default',
		));
		
		$payment_enabled_col->add_bool("enabled", array(
			"label" => ___('bauth.payments.user.enable', array(':title' => $this->_params['title'])),
		));
	}
}