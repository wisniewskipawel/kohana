<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_Offer_Renew extends Bform_Form {

	public function  create(array $params = array()) 
	{
		$offer = $params['offer'];
		
		$this->param('i18n_namespace', 'offers.forms');
		
		$timestamp_availability = strtotime($offer->offer_availability);
		
		$this->form_data(array(
			'offer_availability' => date('Y-m-d', $timestamp_availability),
			'coupon_expiration' => $offer->coupon_expiration,
		));

		$max_days_availability = offers::config('availability_max_days');
		
		$this->add_datepicker('offer_availability', array(
			'date_from' => $offer->offer_availability,
			'date_to' => $max_days_availability ? date('Y-m-d', $timestamp_availability+($max_days_availability*Date::DAY)) : NULL,
		));
		
		if($offer->coupon_expiration)
		{
			$this->add_datepicker('coupon_expiration', array(
				'required' => TRUE,
				'date_from' => $this->form_data('offer_availability') ? $this->form_data('offer_availability') : date('Y-m-d'),
				'html_after' => ___('offers.forms.coupon_expiration_info'),
			));
		}
		
		$this->add_input_submit(___('form.save'));

		$this->template('site');
	}

}
