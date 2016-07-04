<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/
class Payment_Provider_PayU_Online extends Payment_Provider {
	
	protected $_discount_allowed = TRUE;
	
	public function start_payment()
	{
		$formData = array();
		
		if ($user = BAuth::instance()->get_user())
		{
			$formData['email'] = $user->user_email;
		}
		
		$formUserDetails = Bform::factory(new Form_PayU_UserDetails, $formData);
		
		if($formUserDetails->validate())
		{
			$values = $formUserDetails->get_values();
			$data = $this->_module->get_payment_data();

			$payu = new PayU($this);
			$payu->set_field('first_name', Arr::get($values, 'first_name'));
			$payu->set_field('last_name', Arr::get($values, 'last_name'));
			$payu->set_field('email', Arr::get($values, 'email'));
			$payu->set_field('amount', (int)$this->_module->get_price()*100);
			$payu->set_field('desc', $data['description']);
			$payu->set_field('client_ip', Request::$client_ip);
			$payu->set_field('session_id', $this->_module->get_payment_token());
			$payu->set_field('order_id', $this->_module->get_payment_model()->pk());
			$payu->set_field('desc2', $data['uid']);

			return $payu->render_form();
		}
		
		return $formUserDetails;
	}
	
	public function check($values = NULL)
	{
		$payu = new PayU($this);
		
		return $payu->validate($values);
	}
	
	public function finish($values = NULL)
	{
		$payu = new PayU($this);
		
		$status = $payu->get_transaction_state($values);
		
		if($status !== FALSE)
		{
			//save transaction to db
			$this->_module->get_payment_model()
				->set_transaction($payu->get_transaction_id());

			if($status === PayU::STATUS_SUCCESS)
			{
				return $this->_module->success(FALSE);
			}
			elseif($status === PayU::STATUS_FAILED)
			{
				$this->_module->set_status(Model_Payment::STATUS_ERROR);
				
				return Payment_Module::ERROR;
			}
			else
			{
				return Payment_Module::PENDING;
			}
		}
	}
	
	public function get_name()
	{
		return 'payu_online';
	}
	
	public function get_config_path($array = TRUE)
	{
		return $array ? '[payu][online]' : 'payu.online';
	}
	
	public function get_label()
	{
		return 'PayU Online';
	}
	
	public function settings_provider_form($form)
	{
		$tab = $form->add_tab($this->get_name(), $this->get_label(), array(
			'get_values_path' => 'payment.'.$this->get_config_path(FALSE),
			'set_values_path' => 'payment.'.$this->get_config_path(FALSE),
		));
		
		$tab->add_input_text('pos_id', array('label' => 'ID punktu płatności'));
		$tab->add_input_text('key', array('label' => 'Klucz (MD5)'));
		$tab->add_input_text('key2', array('label' => 'Drugi klucz (MD5)'));
		$tab->add_input_text('pos_auth_key', array('label' => 'Klucz autoryzacji płatności (pos_auth_key)'));
		
		$tab->add_html(
			'<strong>Adres powrotu - błąd:</strong><br/>'.
			Route::url(
				'frontend/payment/payu/error', 
				array('provider_name' => $this->get_name()), 
				'http'
			).'?error=%error%&token=%sessionId%&trans_id=%transId%'
		);
		
		$tab->add_html(
			'<strong>Adres powrotu - poprawnie:</strong><br/>'.
			Route::url(
				'frontend/payment/payu/success', 
				array('provider_name' => $this->get_name()), 
				'http'
			).'?token=%sessionId%&trans_id=%transId%'
		);
		
		$tab->add_html(
			'<strong>Adres raportów:</strong><br/>'.
			Route::url('frontend/payment/payu/ipn', array('provider_name' => $this->get_name()), 'http')
		);
		
		$tab->add_fieldset('texts', 'Teksty płatności', array(
			'get_values_path' => 'texts',
			'set_values_path' => 'texts',
		));
		
		$tab->texts->add_editor("default", array(
			"label" => "Skrócona treść płatności", 
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> 'Nazwa opłacanej usługi',
				'price'		=> 'Kwota płatności',
			),
		));

		$tab->texts->add_editor("details", array(
			"label" => "Szczegóły płatności", 
			"editor_type" => "simple_admin",
			'placeholders' => array(
				'title'			=> 'Nazwa opłacanej usługi',
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
		return 'payu';
	}
	
}
