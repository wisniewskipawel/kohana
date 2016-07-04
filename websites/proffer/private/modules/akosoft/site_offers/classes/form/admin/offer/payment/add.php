<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Offer_Payment_Add extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		parent::create(array(
			'payment_disabled' => FALSE,
			'module' => 'site_offers', 
			'place' => 'offer_add',
			'title' => ___('offers.payments.offer_add.title'),
			'values' => $params,
		));
	}
	
	protected function tab_general_top()
	{
		$payment_enabled_col = $this->general->add_collection('payment_enabled', array(
			'get_values_path' => 'offer_add.default',
			'set_values_path' => 'offer_add.default',
		));
		
		$payment_enabled_col->add_select("enabled", array(
			NULL => ___('offers.admin.payments.enabled_values.disabled'),
			1	=> ___('offers.admin.payments.enabled_values.all'),
			2	=> ___('offers.admin.payments.enabled_values.not_registered'),
		), array('label' => ___('offers.admin.payments.offer_add.title'), 'required' => FALSE));
	}
	
}