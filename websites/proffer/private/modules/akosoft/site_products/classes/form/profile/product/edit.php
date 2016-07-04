<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_Product_Edit extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'products.forms');
		
		$product = $params['product'];
		$values = $product->as_array();
		
		$tags = new Model_Product_Tag;
		$tags->filter_by_product($product);
		$values['product_tags'] = $tags->as_string();
		
		$this->form_data($values);
		
		$types_select = Products::types();
		$this->add_select('product_type', Arr::unshift($types_select, NULL, ___('select.choose')));

		$this->add_input_text('product_title')
			->add_validator('product_title', 'Bform_Validator_Length', array('min' => 5, 'max' => 75))
			->add_validator('product_title', 'Bform_Validator_Html');

		$this->add_editor('product_content', array('required' => FALSE, 'editor_type' => 'simple'))
			->add_filter('product_content', 'Bform_Filter_CleanHTML', array('config' => Kohana::$config->load('purifier.forms.product')));

		$this->add_input_text('product_manufacturer', array('required' => FALSE))
			->add_validator('product_manufacturer', 'Bform_Validator_Html');
		
		$this->add_price('product_price', array('required' => FALSE));
		
		$this->add_bool('product_price_to_negotiate');

		$states = products::states();
		$this->add_select('product_state', $states, array('required' => FALSE));

		$this->add_bool('product_buy');
		
		$this->add_input_text('product_allegro_url', array('required' => FALSE))
			->add_validator('product_allegro_url', 'Bform_Validator_Url');
		
		$this->add_input_text('product_shop_url', array('required' => FALSE))
			->add_filter('product_shop_url', 'Bform_Filter_IDNA')
			->add_validator('product_shop_url', 'Bform_Validator_Url');

		if(!$product->has_company())
		{
			$person_types = products::person_types();
			$this->add_select('product_person_type', $person_types);

			$this->add_input_text('product_person', array(
					'label' => 'products.forms.product_person_labels.'.$this->form_data('product_person_type'),
				))
				->add_validator('product_person', 'Bform_Validator_Html');

			$this->add_input_text('product_telephone', array('label' => 'telephone', 'required' => FALSE))
				->add_validator('product_telephone', 'Bform_Validator_Html');
			
			$this->add_input_email('product_email', array('label' => 'Email'));
			
			$this->add_input_text('product_fax', array('label' => 'Fax', 'required' => FALSE))
				->add_validator('product_fax', 'Bform_Validator_Html');
			
			$this->add_input_text('product_www', array('label' => 'WWW', 'required' => FALSE))
				->add_filter('product_www', 'Bform_Filter_IDNA')
				->add_validator('product_www', 'Bform_Validator_Url');

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
		}

		$this->add_input_text('product_tags', array('required' => FALSE))
			->add_validator('product_tags', 'Bform_Validator_Html');
		
		$this->add_input_submit(___('form.save'));

		$this->template('site');
	}
	
}
