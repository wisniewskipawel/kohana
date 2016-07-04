<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Offer_Add extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms');
		
		$current_user = BAuth::instance()->is_logged() ? BAuth::instance()->get_user() : FALSE;
		
		if($current_user)
		{
			$this->form_data(array(
				'offer_person_type' => $current_user->data->users_data_person_type,
				'offer_person' => $current_user->data->users_data_person,
				'offer_city' => $current_user->data->users_data_city,
				'offer_postal_code' => $current_user->data->users_data_postal_code,
				'offer_street' => $current_user->data->users_data_street,
				'offer_telephone' => $current_user->data->users_data_telephone,
				'offer_email' => $current_user->user_email,
				'offer_fax' => $current_user->data->users_data_fax,
				'offer_www' => $current_user->data->users_data_www,
				'province_select' => $current_user->data->users_data_province,
				'offer_county' => $current_user->data->users_data_county,
			));
		}

		$categories = ORM::factory('Offer_Category')->get_list(1);
		$categories_select = array();
		$categories_select[NULL] = ___('select.choose');
		foreach ($categories as $c)
		{
			$categories_select[$c->category_id] = $c->category_name;
		}

		$this->add_select('category_id', $categories_select);

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

		$this->add_input_text('download_limit', array('required' => !$current_user))
			->add_validator('download_limit', 'Bform_Validator_Integer');

		$max_days_availability = offers::config('availability_max_days');
		
		$this->add_datepicker('offer_availability', array(
			'date_from' => date('Y-m-d'),
			'date_to' => $max_days_availability ? date('Y-m-d', time()+($max_days_availability*Date::DAY)) : NULL,
		));

		$this->add_datepicker('coupon_expiration', array(
			'required' => TRUE,
			'date_from' => $this->form_data('offer_availability') ? $this->form_data('offer_availability') : date('Y-m-d'),
			'html_after' => ___('offers.forms.coupon_expiration_info'),
		));

		$this->add_input_text('limit_per_user')
			->add_validator('limit_per_user', 'Bform_Validator_Integer')
			->add_validator('limit_per_user', 'Bform_Validator_Range', array('min' => 1));

		if (!$params['has_promoted_companies'])
		{
			$person_types = offers::person_types();
			$this->add_select('offer_person_type', $person_types);
			
			$this->add_input_text('offer_person')
				->add_validator('offer_person', 'Bform_Validator_Html');
			
			$this->add_input_nip('offer_company_nip', array('required' => FALSE));

			if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled'))
			{
				$this->add_select('province_select', offers::provinces(), array('label' => 'province', 'class' => 'provinces'));

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
		
		if (Modules::enabled('site_catalog') AND $current_user)
		{
			$companies_select = ORM::factory('Catalog_Company')->get_for_select_from_user($current_user);
			
			if($companies_select)
			{
				$this->add_select('company_id', Arr::unshift($companies_select, NULL, ___('select.choose')), array(
					'required' => FALSE,
				));
			}
		}

		$this->add_input_file('image1', array('label' => 'offers.forms.image', 'required' => FALSE))
			->add_validator('image1', 'Bform_Validator_File_Filesize', array('filesize' => '1M'))
			->add_validator('image1', 'Bform_Validator_File_Image');

		if (!$current_user)
		{
			$this->add_captcha('captcha');
			
			$this->add_agreements('agreements');
		}

		$this->add_input_submit(___('form.add'));
		
		$this->template('site');
		$this->param('layout', 'frontend/offers/forms/add_offer');
	}

}
