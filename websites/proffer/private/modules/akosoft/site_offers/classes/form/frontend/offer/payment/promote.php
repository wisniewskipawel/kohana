<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Frontend_Offer_Payment_Promote extends Bform_Form {
	
	public function create(array $params = array())
	{
		$payment_module = $params['payment_module'];
		$type = $params['type'];
		$has_premium_plus_company = $params['has_premium_plus_company'];
		$current_user = BAuth::instance()->get_user();
		
		$this->add_group_radio('payment_method', NULL, array('label' => ''));
		
		if($has_premium_plus_company)
		{
			$this->payment_method->add_option(
				'company_premium_plus', 
				___('offers.promote.promotions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS.'.company_free')
			);
		}
		else
		{
			if($providers = $payment_module->get_providers($type))
			{
				foreach ($providers as $provider_name => $provider)
				{
					$this->payment_method->add_option(
						$provider_name, 
						___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider, 'premium_plus').'</span>'
					);
				}

				if($current_user AND $current_user->data->offer_points)
				{
					$this->payment_method->add_option(
						'offer_points', 
						___('offers.promote.points', array(':promo' => $current_user->data->offer_points))
					);
				}
			}
		}
		
		$this->add_input_submit(___('form.next'));
	}
	
}
