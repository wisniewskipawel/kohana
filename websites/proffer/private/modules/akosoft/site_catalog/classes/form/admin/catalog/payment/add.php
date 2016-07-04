<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Payment_Add extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		parent::create(array(
			'payment_disabled' => FALSE,
			'module' => 'site_catalog', 
			'place' => 'company_add',
			'title' => ___('catalog.payments.company_add.title'),
			'values' => $params,
		));
	}
	
	protected function tab_general_top()
	{
		$payment_enabled_col = $this->general->add_collection('payment_enabled', array(
			'get_values_path' => 'company_add.default',
			'set_values_path' => 'company_add.default',
		));
		
		$payment_enabled_col->add_select("enabled", array(
			NULL => ___('catalog.payments.company_add.disabled'),
			1	=> ___('catalog.payments.company_add.enabled_all'),
			2	=> ___('catalog.payments.company_add.enabled_not_registered'),
		), array('label' => ___('catalog.payments.company_add.enabled.label', array(
			':title' => $this->_params['title'],
		)), 'required' => FALSE));
	}
	
}