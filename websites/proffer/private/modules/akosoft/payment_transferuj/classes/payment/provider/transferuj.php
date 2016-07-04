<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Payment_Provider_Transferuj extends Payment_Provider {
	
	protected $_discount_allowed = TRUE;
	
	public function init()
	{
		if(!$this->config('client_id') OR !$this->config('security_code'))
		{
			throw new Kohana_Exception('Transferuj.pl payment provider is not configured!');
		}

		parent::init();
	}

	public function start_payment()
	{
		$data = $this->_module->get_payment_data();
		
		$data['provider_type'] = $this->get_name();
		$data['payment_module'] = $this->_module;
		$data['provider'] = $this;
		
		$form = Bform::factory('Frontend_Payment_Transferuj', $data);
		
		return $form->render();
	}
	
	public function postback_validate($data)
	{
		$sum_check = md5(
			$data['id'].
			$data['tr_id'].
			$data['tr_amount'].
			$data['tr_crc'].
			$this->config('security_code')
		);

		return $sum_check === $data['md5sum'];
	}
	
	public function finish($values = NULL)
	{
		
	}
	
	public function get_name()
	{
		return 'transferuj';
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '[transferuj]' : 'transferuj';
	}
	
	public function get_label()
	{
		return ___('transferuj.label');
	}
	
	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_text('client_id', array('label' => 'transferuj.forms.provider.client_id'))
			->add_validator('client_id', 'Bform_Validator_Integer');
		
		$tab->add_input_text('security_code', array('label' => 'transferuj.forms.provider.security_code'));
		
		//texts
		
		$texts = $tab->add_fieldset('transferuj_texts', ___('transferuj.forms.provider.texts.label'), array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
		
		$texts->add_editor('default', array(
			"label" => ___("transferuj.forms.provider.texts.default.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'		=> 'Nazwa opłacanej usługi',
				'price'		=> 'Kwota płatności',
			),
		));

		$texts->add_editor('details', array(
			"label" => ___("transferuj.forms.provider.texts.details.label"),
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'		=> 'Nazwa opłacanej usługi',
				'price'		=> 'Kwota płatności',
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
		
		$prices_tab = $form->add_tab($this->get_name()."_prices", $this->get_label(), array(
			'get_values_path' => $config_path,
			'set_values_path' => $config_path,
		));

		foreach($types as $type)
		{
			$account_fs = $prices_tab->add_collection($this->get_name()."_prices_".$place.'_'.$type, array(
				'get_values_path' => $type,
				'set_values_path' => $type,
			));
			
			$account_fs->add_input_text("price", array("label" => "Cena (kwota) za ".$module_title[$type]))
				->add_validator("price", "Bform_Validator_Numeric")
				->add_filter("price", "Bform_Filter_Float");
		}
	}
	
	public function get_currency_type()
	{
		return 'transferuj';
	}
	
}
