<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Payment_Settings_Common extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->form_data($params);
		
		$tab_general = $this->add_tab('general', ___('payments.forms.settings.general'), array(
			'get_values_path' => 'payment',
			'set_values_path' => 'payment',
		));
		
		$all_payment_types = payment::get_providers();
		
		foreach ($all_payment_types as $payment_provider)
		{
			$config_path = $payment_provider->get_config_path(FALSE);
			
			$provider_col = $tab_general->add_collection($payment_provider->get_name(), array(
				'get_values_path' => $config_path,
				'set_values_path' => $config_path,
			));
			
			$provider_col->add_bool("enabled", array(
				'label' => ___('payments.forms.settings.provider_enabled', array(':label' => $payment_provider->get_label())),
			));
		}
		
		foreach ($all_payment_types as $payment_provider)
		{
			if($this->form_data('payment.'.$payment_provider->get_config_path(FALSE).'.enabled'))
			{
				$payment_provider->settings_provider_form($this);
			}
		}
		
		$this->add_input_submit(___('form.save'));
	}
	
}
