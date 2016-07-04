<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Frontend_Catalog_Company_Add extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		/** @var Payment_Module $payment_module */
		$payment_module = $params['payment_module'];

		/** @var Catalog_Company_Promotion_Type $type */
		$type = $params['type'];

		$this->param('i18n_namespace', 'catalog');
		
		$this->add_collection('category', array(
			'set_values_path' => '',
		));
		
		$this->add_partial_categories(0);
		
		for($i=1; $i < $type->get_limit('categories'); $i++)
		{
			$this->add_partial_categories($i);
		}
		
		$this->add_input_text('company_name')
			->add_validator('company_name', 'Bform_Validator_Html');

		$this->add_input_file('logo', array('required' => FALSE))
			->add_validator('logo', 'Bform_Validator_File_Image')
			->add_validator('logo', 'Bform_Validator_File_Filesize', array('filesize' => '1M'));

		if(catalog::config('map'))
		{
			$province_select = catalog::provinces();
			$this->add_select('province_select', $province_select, array('label' => 'province', 'class' => 'provinces geocode-province'));
			
			$couties = array(NULL => ___('select.choose_province'));
			if($this->form_data('province_select'))
			{
				$couties = Regions::counties($this->form_data('province_select'));
			}

			$this->add_select('company_county', $couties, array('label' => 'county', 'class' => 'counties geocode-county'));
		}
		
		$address_required = ($this->form_data('province_select') != Regions::ALL_PROVINCES
			OR !$this->form_data('province_select'));
		
		$this->add_input_text('company_address', array(
			'class' => 'geocode-street',
			'required' => $address_required,
		))
			->add_validator('company_address', 'Bform_Validator_Html');
		
		$this->add_input_text('company_postal_code', array(
			'class' => 'geocode-postalcode',
			'required' => $address_required,
		))
			->add_validator('company_postal_code', 'Bform_Validator_Html');
		
		$this->add_input_text('company_city', array(
			'class' => 'geocode-city',
			'required' => $address_required,
		))
			->add_validator('company_city', 'Bform_Validator_Html');
		
		$this->add_map('company_map', array(
			'required' => FALSE,
			'field_lat' => 'company_map_lat', 
			'field_lng' => 'company_map_lng',
			'geocode' => TRUE,
		));
		
		$this->add_input_text('company_telephone')
			->add_validator('company_telephone', 'Bform_Validator_Html');
		
		$this->add_input_email('company_email');

		if(!$type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
		{
			$this->add_input_text('link', array('required' => FALSE))
				->add_filter('link', 'Bform_Filter_IDNA')
				->add_validator('link', 'Bform_Validator_Url');
		}
		
		if($type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
		{
			$this->add_textarea('company_description', array('chars_counter' => 200))
				->add_validator('company_description', 'Bform_Validator_Html')
				->add_validator('company_description', 'Bform_Validator_Length', array('max' => 200));
		}
		else
		{
			$this->add_editor('company_description', array('editor_type' => 'simple'))
				->add_filter('company_description', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.catalog_company')));
		}
		
		if($type->get_limit('products'))
		{
			$this->add_editor('company_products', array('editor_type' => 'simple', 'required' => FALSE))
				->add_filter('company_products', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.catalog_company')));
		}
		
		if($type->get_limit('keywords'))
		{
			$this->add_input_text('company_keywords', array(
				'required' => FALSE,
				'label_help' => $this->trans('company_keywords_label_help'),
				))
				->add_validator('company_keywords', 'Bform_Validator_Html');
		}
			
		$this->add_input_text('company_nip', array('required' => FALSE, 'label' => 'nip'))
			->add_validator('company_nip', 'Bform_Validator_Html');
		
		if($image_limit = $type->get_limit('images'))
		{
			$this->add_file_uploaderjs('photos', array('amount' => $image_limit, 'type' => 'images', 'label' => 'images.add'));
		}
		
		if($type->is_type(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS))
		{
			$this->add_input_text('slug', array('required' => TRUE))
				->add_validator('slug', 'Form_Validator_Company_Slug');
		}
		
		if($type->get_limit('hours'))
		{
			$this->add_company_hours('company_hours', array('required' => FALSE));
		}
		
		if(!BAuth::instance()->is_logged())
		{
			$this->add_captcha('captcha');
			
			$this->add_agreements('agreements');
		}

		if($payment_module->is_enabled())
		{
			$discount = NULL;
			if(BAuth::instance()->is_logged())
			{
				$discount = BAuth::instance()->get_user()->data->catalog_discount;
			}

			$this->add_payments('payments', $payment_module, array(
				'payment_type' => $type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC) ? NULL : FALSE,
				'discount' => $discount,
			));
		}
		
		$this->add_input_submit(___('form.add'));

		$this->template('site');
		$this->param('layout', 'frontend/catalog/forms/add');
		$this->param('layout_data', array(
			'type' => $type,
		));
	}
	
	public function add_partial_categories($index, Model_Company_Category $category = NULL)
	{
		$this->category->add_orm_categories('category_'.$index, $category, array(
			'label' => ___('catalog.category_nb', array(':nb' => $index+1)),
			'orm' => 'Catalog_Category',
			'required' => !$index,
			'row_class' => 'full',
		));

		return TRUE;
	}
}
