<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Payment_Settings extends Bform_Form {
	
	protected $_params = NULL;
	protected $_module = NULL;
	
	public function create(array $params = array()) 
	{
		$this->_params = $params;
		
		$this->form_data(Arr::get($params, 'values'));
		
		if(empty($params['types']))
		{
			$params['types'] = array('default');
			$params['title'] = array('default' => Arr::get($params, 'title'));
		}
		
		$module = Arr::get($params, 'module');
		$place = Arr::get($params, 'place');
		$module_title = Arr::get($params, 'title');
		$types = Arr::get($params, 'types');
		
		$this->add_tab("general", ___('payments.forms.settings.general'), array(
			'get_values_path' => $module.'.payment',
			'set_values_path' => $module.'.payment',
		));
		
		$this->tab_general_top();
		
		if(Arr::get($params, 'payment_disabled') !== FALSE)
		{
			$this->general->add_fieldset('providers_disable', ___('payments.forms.settings.payment_disable_tab'), array(
				'get_values_path' => $place,
				'set_values_path' => $place,
			));
		
			if(!isset($params['payment_disabled']))
			{
				foreach($types as $type)
				{
					$payment_disabled_type_col = $this->general->providers_disable->add_collection($type, array(
						'get_values_path' => $type,
						'set_values_path' => $type,
					));
					
					$payment_disabled_type_col->add_bool("disabled", array(
						"label" => ___('payments.forms.settings.payment_disable', array(
							':label' => $module_title[$type],
						)),
					));
				}
			}
			else
			{
				foreach($params['payment_disabled'] as $type => $name)
				{
					$payment_disabled_type_col = $this->general->providers_disable->add_collection($type, array(
						'get_values_path' => $type,
						'set_values_path' => $type,
					));
					
					$payment_disabled_type_col->add_bool("disabled", array(
						"label" => ___('payments.forms.settings.payment_disable', array(
							':label' => $name,
						)),
					));
				}
			}
		}
		
		$this->general->add_fieldset('providers_tab', ___('payments.forms.settings.providers_tab'));
		
		$all_payment_types = payment::get_providers();
		
		foreach ($all_payment_types as $payment_provider)
		{
			if($payment_provider->is_enabled())
			{
				$config_path = $payment_provider->get_config_path(FALSE).'.'.$place;

				if(isset($params['per_type_enabled']))
				{
					$config_path .= '.'.Arr::get($types, 0, 'default');
				}
				
				$provider_enable_collection = $this->general->providers_tab->add_collection($payment_provider->get_name(), array(
					'get_values_path' => $config_path,
					'set_values_path' => $config_path,
				));

				$provider_enable_collection->add_bool("enabled", array(
					"label" => ___('payments.forms.settings.provider_enabled', array(':label' => $payment_provider->get_label())),
				));
			}
		}
		
		foreach($all_payment_types as $payment_provider)
		{
			if($payment_provider->is_enabled() AND $this->form_data($module.'.payment.'.$payment_provider->get_config_path(FALSE).'.'.$place.'.'.(isset($params['per_type_enabled']) ? Arr::get($types, 0, 'default').'.' : '').'enabled'))
			{
				$payment_provider->settings_module_form($this, $params);
			}
		}

		$this->add_input_submit(___('form.save'));
	}
	
	protected function tab_general_top()
	{
		
	}
	
}
