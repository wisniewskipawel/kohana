<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Ad_Settings_Payment extends Form_Admin_Payment_Settings {

	public function  create(array $params = array())
	{
		$availabilities = Ads::availabilities(Model_Ad::TEXT_C);
		$params = array(
			'module' => 'site_ads', 
			'place' => 'ad_'.Model_Ad::TEXT_C, 
			'types' => array_keys($availabilities),
			'title' => $availabilities,
			'payment_disabled' => array(
				'default' => ___('ads.payment.link_text'),
			),
			'values' => Arr::get($params, 'values')
		);

		parent::create($params);
	}

}