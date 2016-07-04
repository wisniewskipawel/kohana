<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Admin_Catalog_Payment_Promote extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		$payment_module = new Payment_Company_Promote;
		$types = Catalog_Company_Promotion_Types::for_select($payment_module->get_types());
		
		parent::create(array(
			'module' => $payment_module->get_module_name(), 
			'place' => $payment_module->place(), 
			'types' => array_keys($types),
			'title' => $types,
			'values' => $params,
		));
	}
	
}