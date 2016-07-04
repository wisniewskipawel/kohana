<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Payment_Provider_Transfer extends Payment_Provider {
	
	protected $_discount_allowed = TRUE;
	
	public function init()
	{
		$object = $this->_module->object();
		
		$payment_info = $this->_module->get_payment_data();
		
		$tags = array(
			'payment_description' => Arr::get($payment_info, 'description'),
			'bank_account_number' => Arr::get($this->_config, 'bank_account_number'),
			'address_information' => Text::auto_p(Arr::get($this->_config, 'address_information')),
			'price' => $this->_module->show_price($this),
			'transfer_title' => $this->_module->get_payment_token(),
		);
		
		if($object instanceof IEmailMessageReceiver AND $object->get_email_address())
		{
			$email = new Model_Email();
			$email->find_by_alias('payment_transfer');

			$payment_info = $this->_module->get_payment_data();

			if($email->loaded())
			{
				$email->set_tags(array(
					'%payment_description%' => Arr::get($tags, 'payment_description'),
					'%bank_account_number%' => Arr::get($tags, 'bank_account_number'),
					'%address_information%' => Arr::get($tags, 'address_information'),
					'%price%' => Arr::get($tags, 'price'),
					'%transfer_title%' => Arr::get($tags, 'transfer_title'),
				));

				$object->send_email_message($email);
			}
			else
			{
				throw new Kohana_Exception('Cannot find e-mail template :alias', array(':alias' => 'payment_transfer'));
			}
		}
	}
	
	public function start_payment()
	{
		$payment_info = $this->_module->get_payment_data();
		
		$tags = array(
			'payment_description' => Arr::get($payment_info, 'description'),
			'bank_account_number' => Arr::get($this->_config, 'bank_account_number'),
			'address_information' => Text::auto_p(Arr::get($this->_config, 'address_information')),
			'price' => $this->_module->show_price($this),
			'transfer_title' => $this->_module->get_payment_token(),
		);
		
		return View::factory('payment/transfer/details', $tags);
	}
	
	public function finish($values = NULL)
	{
		return $this->_module->success(FALSE);
	}
	
	public function get_name()
	{
		return 'transfer';
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '[transfer]' : 'transfer';
	}
	
	public function get_label()
	{
		return ___('transfer.provider.label');
	}
	
	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_text('bank_account_number', array(
			'label' => ___('transfer.provider.bank_account_number'),
		));
		
		$tab->add_textarea('address_information', array(
			'label' => ___('transfer.provider.address_information'),
		));
		
		$texts_fs = $tab->add_fieldset('texts', ___('transfer.provider.texts.title'), array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
		
		$texts_fs->add_editor("default", array(
			"label" => ___("transfer.provider.texts.default.label"), 
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> ___('transfer.provider.texts.placeholders.title'),
				'price'		=> ___('transfer.provider.texts.placeholders.price'),
			),
		));
	}
	
	public function settings_module_form($form, $params)
	{
		$module = Arr::get($params, 'module');
		$place = Arr::get($params, 'place');
		$module_title = Arr::get($params, 'title');
		$types = Arr::get($params, 'types');
		
		$config_path = $this->get_config_path(FALSE);
		$config_path = $module.".payment.{$config_path}.$place";
		
		$prices_tab = $form->add_tab("transfer_prices", $this->get_label(), array(
			'get_values_path' => $config_path,
			'set_values_path' => $config_path,
		));

		foreach($types as $type)
		{
			$account_fs = $prices_tab->add_collection($this->get_name()."-account-".$place.'-'.$type, array(
				'get_values_path' => $type,
				'set_values_path' => $type,
			));
			
			$account_fs->add_input_text("price", array(
				"label" => ___('transfer.module.price', array(':title' => $module_title[$type]))
			))
				->add_validator("price", "Bform_Validator_Numeric")
				->add_filter("price", "Bform_Filter_Float");
		}
	}
	
	public function get_currency_type()
	{
		return 'transfer';
	}
	
}
