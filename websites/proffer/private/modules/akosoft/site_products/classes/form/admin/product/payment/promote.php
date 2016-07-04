<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Product_Payment_Promote  extends Form_Admin_Payment_Settings {
    
	public function  create(array $params = array())
	{
		$payment_module = new Payment_Product_Promote;
		$types = $payment_module->types();
		
		parent::create(array(
			'module' => $payment_module->get_module_name(), 
			'place' => $payment_module->place(), 
			'types' => array_keys($types),
			'title' => $types,
			'values' => $params,
			'per_type_enabled' => TRUE,
		));
	}

}