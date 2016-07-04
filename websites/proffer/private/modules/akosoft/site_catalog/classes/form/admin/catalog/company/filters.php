<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Company_Filters extends Bform_Form {

	public function  create(array $params = array()) 
	{
		$this->method('get');
		$this->param('save_get_values', FALSE);
		$this->form_data(Request::current()->query());
		
		$this->add_input_text('company_id', array(
			'label' => ___('catalog.filters.company_id'),
			'required' => FALSE,
		))
			->add_validator('company_id', 'Bform_Validator_Integer');
		
		$select = array(
			'all'		=> ___('catalog.filters.all'),
			'now'	=> ___('catalog.filters.promoted.now'),
			'past'	=> ___('catalog.filters.promoted.past'),
			'no'		=> ___('catalog.filters.promoted.no'),
		);

		$categories = ORM::factory('Catalog_Category')->get_select_tree();
		unset($categories[1]);
		Arr::unshift($categories, NULL, ___('catalog.filters.all'));
		
		$this->add_select('promoted', $select, array(
			'label' => 'catalog.filters.promoted.title',
			'required' => FALSE,
		));
		
		$this->add_select('category_id', $categories, array('label' => 'category', 'required' => FALSE));

		if ( ! empty($params))
		{
			$this->add_html(HTML::anchor('/admin/catalog/companies', ___('filters.clear')));
		}
		
		$this->add_input_submit(___('form.filter'));
	}

}
