<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Offer_SendCoupon extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms.sendcoupon');
		
		$this->add_input_text('email');
		
		if($params['offer']->get_limit() > 1)
		{
			$amounts = range(1, $params['offer']->get_limit());
			$this->add_select('amount', array_combine($amounts, $amounts))
				->add_validator('amount', 'Bform_Validator_Coupons_Amount', array(
					'dependencies_drivers_names' => array('email'),
					'offer' => $params['offer'],
				));
		}
		
		$this->add_captcha('captcha');
		
		$this->add_input_submit(___('form.send'));
		
		$this->template('site');
	}
	
}
