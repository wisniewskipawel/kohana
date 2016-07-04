<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Company_Edit extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->param('i18n_namespace', 'catalog');
		
		$company = $params['company'];
		
		$values = $company->as_array();
		$values['company_keywords'] = $company->get_tags_as_string();
		
		$categories = $company->get_categories(TRUE);
		
		foreach($categories as $index => $category)
		{
			$values['category_'.$index] = $category->pk();
		}
		
		$this->form_data($values);
		
		$categories_select = ORM::factory('Catalog_Category')->get_select(TRUE);
		Arr::unshift($categories_select, NULL, ___('select.choose'));
		
		$this->add_collection('category', array(
			'set_values_path' => '',
		));
		
		$categories_limit = $company->get_promotion_type_limit('categories');
		for($index=0; $index < $categories_limit; $index++)
		{
			$this->category->add_select('category_'.$index, $categories_select, array(
				'label' => ___('catalog.admin.forms.company.add.category', array(':nb' => $index+1)),
				'required' => !$index,
				'id' => 'category_'.$index,
			));
		}
		
		$this->add_input_text('company_name')
			 ->add_validator('company_name', 'Bform_Validator_Html');
		
		if (Kohana::$config->load('modules.site_catalog.map'))
		{
			$province_select = catalog::provinces();
			$this->add_select('province_select', $province_select, array('label' => 'province', 'class' => 'provinces'));
			
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
		
		$this->add_input_text('company_telephone')
			 ->add_validator('company_telephone', 'Bform_Validator_Html');
		
		$this->add_input_email('company_email');
		
		$this->add_input_text('link', array('required' => FALSE))
			->add_filter('link', 'Bform_Filter_IDNA')
			->add_validator('link', 'Bform_Validator_Url');
			
		$this->add_input_text('company_nip', array('required' => FALSE, 'label' => 'nip'))
			->add_validator('company_nip', 'Bform_Validator_Html');
		
		$this->add_editor('company_description', array('editor_type' => 'simple_admin'))
			->add_filter('company_description', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.catalog_company')));
		
		$this->add_editor('company_products', array('required' => FALSE, 'editor_type' => 'simple_admin'))
			->add_filter('company_products', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.catalog_company')));
		
		$this->add_company_hours('company_hours', array('required' => FALSE));
		
		$this->add_input_text('slug', array(
			'required' => $this->form_data('promotion_type') == Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS,
		))
			->add_validator('slug', 'Form_Validator_Company_Slug', array('edit_company' => $company));
		
		$this->add_input_text('company_keywords', array(
			'required' => FALSE,
			'label_help' => $this->trans('company_keywords_label_help'),
			))
			->add_validator('company_keywords', 'Bform_Validator_Html');
		
		$this->add_fieldset('promotion', ___('catalog.companies.promotion.title'));

		$types = new Catalog_Company_Promotion_Types();
		$this->promotion->add_select(
			'promotion_type',
			Catalog_Company_Promotion_Types::for_select($types->get_enabled()),
			array(
				'required' => FALSE,
			)
		);
		
		$this->promotion->add_bool('company_is_promoted');
		
		$this->promotion->add_datetime('company_promotion_availability', array('value' => date('Y-m-d H:i')));
		
		$this->add_input_text('user_id', array(
			'label' => ___('user_id'),
			'required' => FALSE,
			'value' => BAuth::instance()->get_user()->pk(),
		))
			->add_validator('user_id', 'Bform_Validator_Integer');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
