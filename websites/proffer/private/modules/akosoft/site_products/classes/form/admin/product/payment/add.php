<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Product_Payment_Add extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		parent::create(array(
			'payment_disabled' => FALSE,
			'module' => 'site_products', 
			'place' => 'product_add',
			'title' => ___('products.payments.product_add.title'),
			'values' => $params,
		));
	}
	
	protected function tab_general_top()
	{
		$payment_enabled_col = $this->general->add_collection('payment_enabled', array(
			'get_values_path' => 'product_add.default',
			'set_values_path' => 'product_add.default',
		));
		
		$payment_enabled_col->add_select("enabled", array(
			NULL => ___('products.admin.payments.enabled_values.disabled'),
			1	=> ___('products.admin.payments.enabled_values.all'),
			2	=> ___('products.admin.payments.enabled_values.not_registered'),
		), array('label' => ___('products.admin.payments.product_add.title'), 'required' => FALSE));
	}
	
}