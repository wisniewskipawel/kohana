<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Profile_Catalog_Company_Promote extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'catalog');
		
		$current_user = $params['current_user'];
		/** @var Catalog_Company_Promotion_Type $promotion_type */
		$promotion_type = $params['promotion_type'];
		$company = $params['company'];
		$values = $company->as_array();
		$values['company_keywords'] = $company->get_tags_as_string();
		$categories = $company->get_categories(TRUE);
		
		foreach($categories as $index => $category)
		{
			$values['category_'.$index] = $category->pk();
		}
		
		$this->form_data($values);
		
		// form definition
		
		$this->add_collection('category', array(
			'set_values_path' => '',
		));
		
		$this->add_partial_categories(0);
		
		$categories_limit = $promotion_type->get_limit('categories');
		for($i=1; $i < $categories_limit; $i++)
		{
			$this->add_partial_categories($i);
		}
		
		$this->add_input_text('company_name')
			->add_validator('company_name', 'Bform_Validator_Html');
		
		if($promotion_type->is_type(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS))
		{
			$this->add_input_text('slug', array('required' => TRUE))
				->add_validator('slug', 'Form_Validator_Company_Slug', array('edit_company' => $company));
		}
		
		if (catalog::config('map'))
		{
			$provinces = catalog::provinces();
			$this->add_select('province_select', $provinces, array('label' => 'province', 'class' => 'provinces'));
			
			$couties = array(NULL => ___('select.choose_province'));
			if($this->form_data('province_select'))
			{
				$couties = Regions::counties($this->form_data('province_select'));
			}

			$this->add_select('company_county', $couties, array('label' => 'county', 'class' => 'counties'));
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
			'start_point' => array(
				'lat' => $this->form_data('company_map_lat'),
				'lng' => $this->form_data('company_map_lng'),
			),
			'row_class' => 'full',
		));
		
		$this->add_input_text('company_telephone')
			->add_validator('company_telephone', 'Bform_Validator_Html');
		
		$this->add_input_email('company_email');
		
		$this->add_input_text('link', array('required' => FALSE))
			->add_filter('link', 'Bform_Filter_IDNA')
			->add_validator('link', 'Bform_Validator_Url');
			
		$this->add_input_text('company_nip', array('required' => FALSE, 'label' => 'nip'))
			->add_validator('company_nip', 'Bform_Validator_Html');
		
		$this->add_editor('company_description', array('editor_type' => 'simple'))
			->add_filter('company_description', 'Bform_Filter_CleanHTML', array(
				'config' => Kohana::$config->load('purifier.forms.catalog_company'),
			));
		
		if($promotion_type->get_limit('products'))
		{
			$this->add_editor('company_products', array(
				'editor_type' => 'simple', 
				'required' => FALSE,
			))
				->add_filter('company_products', 'Bform_Filter_CleanHTML', array(
					'config' => Kohana::$config->load('purifier.forms.catalog_company')
				));
		}
		
		if($promotion_type->get_limit('hours'))
		{
			$this->add_company_hours('company_hours', array('required' => FALSE));
		}
		
		$this->add_input_text('company_keywords', array('required' => FALSE))
			->add_validator('company_keywords', 'Bform_Validator_Html');
		
		$logo = $company->get_logo();
		if($logo AND $logo->exists('catalog_company_list'))
		{
			$this->add_html(HTML::image($logo->get_uri('catalog_company_list')), array(
				'no_decorate' => FALSE,
				'label' => "&nbsp;",
			));
		}
		
		$this->add_input_file('logo', array('required' => FALSE))
			->add_validator('logo', 'Bform_Validator_File_Image')
			->add_validator('logo', 'Bform_Validator_File_Filesize');
		
		$images = $company->get_images();
		$amount_photos = $promotion_type->get_limit('images') - count($images);
		
		if($amount_photos)
		{
			$this->add_file_uploaderjs('photos', array(
				'amount' => $amount_photos, 
				'type' => 'images', 
				'label' => 'images.add',
			));
		}
		
		$this->add_payments('payments', $params['payment_module'], array(
			'payment_type' => $promotion_type->get_id(),
			'discount' => $current_user->data->catalog_discount,
		));
		
		$this->add_input_submit(___('form.next'));

		$this->template('site');
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
