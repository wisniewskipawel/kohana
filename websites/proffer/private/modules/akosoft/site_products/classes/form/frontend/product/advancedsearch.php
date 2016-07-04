<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Product_AdvancedSearch extends Bform_Form {

	public $_method = 'get';

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'products.forms.advanced_search');

		$this->add_input_text('phrase', array('required' => FALSE));
		
		$wheres = array(
			'title_and_description'	 => ___('products.forms.advanced_search.where_values.title_and_description'),
			'title'					 => ___('products.forms.advanced_search.where_values.title'),
			'description'			 => ___('products.forms.advanced_search.where_values.description'),
		);
		
		$this->add_select('where', $wheres, array('required' => FALSE));

		if (Kohana::$config->load('modules.site_products.provinces_enabled'))
		{
			$this->add_select('product_province', products::provinces(), array('label' => 'province', 'class' => 'provinces', 'required' => FALSE));

			$couties = array(NULL => ___('select.choose'));
			if($this->form_data('product_province'))
			{
				$couties += Regions::counties($this->form_data('product_province'));
			}

			$this->add_select('product_county', $couties, array('label' => 'county', 'class' => 'counties', 'required' => FALSE));
		}

		$this->add_input_text('city', array('label' => 'city', 'required' => FALSE));

		$category = NULL;
		if($this->form_data('category_id'))
		{
			$category = new Model_Product_Category((int)$this->form_data('category_id'));
		}

		$this->add_partial_categories($category);

		$this->add_input_text('price_from', array('required' => FALSE))
			->add_filter('price_from', 'Bform_Filter_Float');
		
		$this->add_input_text('price_to', array('required' => FALSE))
			->add_filter('price_to', 'Bform_Filter_Float');

		$this->add_input_text('product_manufacturer', array(
			'label' => 'products.forms.product_manufacturer',
			'required' => FALSE,
		));
		
		$types = Products::types();
		$this->add_select('product_type', Arr::unshift($types, NULL, ___('select.choose')), array('label' => 'products.forms.product_type', 'required' => FALSE));
		
		$this->add_input_submit(___('form.search'));
	}

	public function add_partial_categories(Model_Product_Category $category = NULL)
	{
		$this->add_orm_categories('category_id', $category, array(
			'label' => 'products.forms.category_id', 
			'required' => FALSE, 
			'allow_only_parent' => TRUE, 
			'orm' => 'Product_Category',
			'template' => 'decorated',
			'no_decorate' => TRUE,
		));

		return TRUE;
	}

}
