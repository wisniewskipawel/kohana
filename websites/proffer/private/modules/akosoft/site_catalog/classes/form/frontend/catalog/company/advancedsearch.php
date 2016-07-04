<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Catalog_Company_AdvancedSearch extends Bform_Form {
	
	protected $_method = 'get';
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'catalog');
		
		$this->form_data($params);

		$this->add_input_text('phrase', array('required' => FALSE));
		
		$wheres = array(
			'name_and_description'	=> ___('catalog.where_select.name_and_description'),
			'name'				=> ___('catalog.where_select.name'),
			'description'			=> ___('catalog.where_select.description'),
		);
		$this->add_select('where', $wheres, array('required' => FALSE));

		if (Kohana::$config->load('modules.site_catalog.map'))
		{
			$province_select = catalog::provinces();
			$this->add_select('province_select', $province_select, array('label' => 'province', 'class' => 'provinces','required' => FALSE));
			
			$couties = array(NULL => ___('select.choose_province'));
			if($this->form_data('province_select'))
			{
				$couties = Regions::counties($this->form_data('province_select'));
			}

			$this->add_select('company_county', Arr::unshift($couties, NULL, ___('select.choose')), array(
				'label' => 'county', 
				'class' => 'counties',
				'required' => FALSE,
			));
		}

		$this->add_input_text('city', array('label' => 'city', 'required' => FALSE));
		
		$categories = ORM::factory('Catalog_Category')->get_select_tree();
		unset($categories[1]);
		
		$this->add_select('category_id', Arr::unshift($categories, NULL, ''), array('label' => 'category', 'required' => FALSE));
		
		$this->add_input_submit(___('form.search'));

		$this->template('site');
		
		$this->param('save_get_values', FALSE);
	}
	
}
