<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Payment_Promote extends Form_Admin_Payment_Settings {

	public function  create(array $params = array())
	{
		parent::create(array(
			'module' => 'site_offers', 
			'place' => 'promote', 
			'types' => array(
				'premium_plus'
			),
			'title' => array(
				'premium_plus' => ___('offers.distinctions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS),
			),
			'values' => $params,
			'per_type_enabled' => TRUE,
		));
	}

}