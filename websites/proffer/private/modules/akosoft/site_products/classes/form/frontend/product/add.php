<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Frontend_Product_Add extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'products.forms');
		
		$current_user = BAuth::instance()->is_logged() ? BAuth::instance()->get_user() : FALSE;
		
		$promoted_companies = NULL;

		if($current_user && Modules::enabled('site_catalog'))
		{
			$company = new Model_Catalog_Company;
			$company->filter_by_user($current_user);
			$company->filter_by_promoted();

			$promoted_companies = $company->find_all()->as_array('company_id', 'company_name');
		}
		
		if($current_user)
		{
			$this->form_data(array(
				'product_person_type' => $current_user->data->users_data_person_type,
				'product_person' => $current_user->data->users_data_person,
				'product_city' => $current_user->data->users_data_city,
				'product_postal_code' => $current_user->data->users_data_postal_code,
				'product_street' => $current_user->data->users_data_street,
				'product_telephone' => $current_user->data->users_data_telephone,
				'product_email' => $current_user->user_email,
				'product_fax' => $current_user->data->users_data_fax,
				'product_www' => $current_user->data->users_data_www,
				'product_province' => $current_user->data->users_data_province,
				'product_county' => $current_user->data->users_data_county,
			));
		}
		
		$category = NULL;
		if($this->form_data('category_id'))
		{
			$category = new Model_Product_Category((int)$this->form_data('category_id'));
		}

		$this->add_partial_categories($category);

		$types_select = Products::types();
		$this->add_select('product_type', Arr::unshift($types_select, NULL, ___('select.choose')));

		$this->add_input_text('product_manufacturer', array('required' => FALSE))
			->add_validator('product_manufacturer', 'Bform_Validator_Html');

		$this->add_input_text('product_title')
			->add_validator('product_title', 'Bform_Validator_Length', array('min' => 5, 'max' => 75))
			->add_validator('product_title', 'Bform_Validator_Html');

		$this->add_editor('product_content', array('required' => FALSE, 'editor_type' => 'simple'))
			->add_filter('product_content', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.product')));

		$this->add_bool('product_buy');

		$states = products::states();
		$this->add_select('product_state', $states, array('required' => FALSE));
		
		$this->add_input_text('product_allegro_url', array('required' => FALSE))
			->add_validator('product_allegro_url', 'Bform_Validator_Url');
		
		$this->add_input_text('product_shop_url', array('required' => FALSE))
			->add_filter('product_shop_url', 'Bform_Filter_IDNA')
			->add_validator('product_shop_url', 'Bform_Validator_Url');
		
		$this->add_price('product_price', array('required' => FALSE));
		
		$this->add_bool('product_price_to_negotiate');

		if(!empty($promoted_companies))
		{
			$this->add_input_hidden('product_person_type', 'company');

			$this->add_select('company_id', Arr::unshift($promoted_companies, NULL, ___('select.choose')), array(
				'label' => 'products.forms.company', 
				'required' => $this->form_data('product_person_type') !== 'person',
			));
		}
		else
		{
			$person_types = products::person_types();
			$this->add_select('product_person_type', $person_types);

			$this->add_input_text('product_person', array(
					'label' => 'products.forms.product_person_labels.'.$this->form_data('product_person_type'),
					'required' => !$this->form_data('company_id'),
				))
				->add_validator('product_person', 'Bform_Validator_Html');

			//localization

			if (Kohana::$config->load('modules.site_products.provinces_enabled'))
			{
				$this->add_select('product_province', products::provinces(), array('label' => 'province', 'class' => 'provinces geocode-province'));

				$couties = array(NULL => ___('select.choose_province'));
				if($this->form_data('product_province'))
				{
					$couties = Regions::counties($this->form_data('product_province'));
				}

				$this->add_select('product_county', $couties, array('label' => 'county', 'class' => 'counties geocode-county'));
			}

			$this->add_input_text('product_city', array('label' => 'city', 'required' => FALSE, 'class' => 'geocode-city'))
				->add_validator('product_city', 'Bform_Validator_Html');
			
			$this->add_input_text('product_postal_code', array('label' => 'postal_code', 'required' => FALSE, 'class' => 'geocode-postalcode'))
				->add_validator('product_postal_code', 'Bform_Validator_Html');
			
			$this->add_input_text('product_street', array('label' => 'street', 'required' => FALSE, 'class' => 'geocode-street'))
				->add_validator('product_street', 'Bform_Validator_Html');
		
			$this->add_map('product_map', array(
				'required' => FALSE,
				'field_lat' => 'product_map_lat', 
				'field_lng' => 'product_map_lng',
				'geocode' => TRUE,
				'row_class' => 'full',
			));

			$this->add_input_text('product_telephone', array('label' => 'telephone', 'required' => FALSE))
				->add_validator('product_telephone', 'Bform_Validator_Html');
			
			$this->add_input_email('product_email', array('label' => 'email'));
			
			$this->add_input_text('product_fax', array('label' => 'fax', 'required' => FALSE))
				->add_validator('product_fax', 'Bform_Validator_Html');
			
			$this->add_input_text('product_www', array('label' => 'www', 'required' => FALSE))
				->add_filter('product_www', 'Bform_Filter_IDNA')
				->add_validator('product_www', 'Bform_Validator_Url');
		}
		
		$this->add_input_text('product_tags', array('required' => FALSE))
			->add_validator('product_tags', 'Bform_Validator_Html');
		
		$availabilities = Products::availabilites();
		$this->add_select('product_availability', $availabilities, array('label' => 'products.forms.product_availability_span'));

		$photos_count = $current_user ? Products::config('photos_count.registered') : Products::config('photos_count.guest');

		$this->add_file_uploaderjs('images', array(
			'amount' => $photos_count,
			'type' => Bform_Core_Driver_File_UploaderJS::TYPE_IMAGES,
			'label' => ___('images.add'),
		));

		if (!$current_user)
		{
			$this->add_captcha('captcha');
			
			$this->add_agreements('agreements');
		}

		$this->add_input_submit(___('form.add'));
		
		$this->param('layout_data', array(
			'promoted_companies' => $promoted_companies,
		));
	}

	public function add_partial_categories(Model_Product_Category $category = NULL)
	{
		$this->param('i18n_namespace', 'products.forms');
		
		$this->add_orm_categories('category_id', $category, array('orm' => 'Product_Category'));

		return TRUE;
	}
	
}
