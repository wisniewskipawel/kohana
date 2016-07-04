<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Frontend_Offer_Payment_Add extends Bform_Form {
	
	public function create(array $params = array())
	{
		$payment_module = $params['payment_module'];
		
		$providers = $payment_module->get_providers(); 

		if($providers)
		{
			$this->add_group_radio('payment_method', NULL, array('label' => ''));
			
			foreach ($providers as $provider_name => $provider)
			{
				$this->payment_method->add_option(
					$provider_name, 
					___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider).'</span>'
				);
			}
		}
		
		$this->add_input_submit(___('form.next'));
	}
	
}
