<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_Offer_Edit extends Bform_Form {

	public function  create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms');
		
		$offer = $params['offer'];
		$this->form_data($offer->as_array());

		$this->add_input_text('offer_title')
			->add_validator('offer_title', 'Bform_Validator_Length', array('min' => 5, 'max' => 75))
			->add_validator('offer_title', 'Bform_Validator_Html');
		
		$this->add_editor('offer_content', array('required' => FALSE, 'editor_type' => 'simple'))
			->add_filter('offer_content', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.offer')));

		$this->add_input_text('offer_price_old', array('label' => ___('offers.forms.offer_price_old', array(':currency' => payment::currency('short')))))
			->add_filter('offer_price_old', 'Bform_Filter_Price')
			->add_validator('offer_price_old', 'Bform_Validator_Range', array('min' => 0, 'max' => 999999999))
			->add_validator('offer_price_old', 'Bform_Validator_Html');

		$this->add_offers_price('offer_price', array('label' => ___('offers.forms.offer_price', array(':currency' => payment::currency('short')))))
			->add_filter('offer_price', 'Bform_Filter_Price')
			->add_validator('offer_price', 'Bform_Validator_Html')
			->add_validator('offer_price', 'Bform_Validator_Offer_Price', array(
				'dependencies_drivers_names' => array('offer_price_old'),
			));

		$this->add_input_text('download_limit', array('required' => FALSE))
			->add_validator('download_limit', 'Bform_Validator_Integer');

		$this->add_input_text('limit_per_user')
			->add_validator('limit_per_user', 'Bform_Validator_Integer')
			->add_validator('limit_per_user', 'Bform_Validator_Range', array('min' => 1));

		if(!$offer->has_company())
		{
			$this->add_input_text('offer_person')
				->add_validator('offer_person', 'Bform_Validator_Html');
			
			$this->add_input_nip('offer_company_nip', array('required' => FALSE));

			if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled'))
			{
				$provinces = offers::provinces();
				$this->add_select('province_select', $provinces, array('label' => 'province', 'class' => 'provinces'));

				$couties = array(NULL => ___('select.choose_province'));
				if($this->form_data('province_select'))
				{
					$couties = Regions::counties($this->form_data('province_select'));
				}

				$this->add_select('offer_county', $couties, array('label' => 'county', 'class' => 'counties'));
			}

			$this->add_input_text('offer_city', array('label' => 'city', 'required' => FALSE))
				->add_validator('offer_city', 'Bform_Validator_Html');
			
			$this->add_input_text('offer_postal_code', array('label' => 'postal_code', 'required' => FALSE))
				->add_validator('offer_postal_code', 'Bform_Validator_Html');
			
			$this->add_input_text('offer_street', array('label' => 'street', 'required' => FALSE))
				->add_validator('offer_street', 'Bform_Validator_Html');
			
			$this->add_input_text('offer_telephone', array('label' => 'telephone', 'required' => FALSE))
				->add_validator('offer_telephone', 'Bform_Validator_Html');
			
			$this->add_input_email('offer_email', array('label' => 'email'));
			
			$this->add_input_text('offer_fax', array('label' => 'fax', 'required' => FALSE))
				->add_validator('offer_fax', 'Bform_Validator_Html');
			
			$this->add_input_text('offer_www', array('required' => FALSE))
				->add_filter('offer_www', 'Bform_Filter_IDNA')
				->add_validator('offer_www', 'Bform_Validator_Url');
		}

		$this->add_input_submit(___('form.save'));

		$this->template('site');
	}

}
