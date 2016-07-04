<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Offer_AdvancedSearch extends Bform_Form {

	protected $_method = 'get';
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms.advanced_search');
		
		$this->form_data($params);

		$this->add_input_text('phrase', array('required' => FALSE));
		
		$wheres = array(
			'title_and_description'	=> ___('offers.forms.advanced_search.where_values.title_and_description'),
			'title'					=> ___('offers.forms.advanced_search.where_values.title'),
			'description'			=> ___('offers.forms.advanced_search.where_values.description'),
		);
		$this->add_select('where', $wheres, array('required' => FALSE));

		if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled'))
		{
			$this->add_select('province_select', offers::provinces(), array('label' => 'province', 'class' => 'provinces', 'required' => FALSE));

			$couties = array(NULL => ___('select.choose_province'));
			if($this->form_data('province_select'))
			{
				$couties = Regions::counties($this->form_data('province_select'));
			}

			$this->add_select('offer_county', Arr::unshift($couties, NULL, ___('select.choose')), array('label' => 'county', 'class' => 'counties', 'required' => FALSE));
		}

		$this->add_input_text('city', array('label' => 'city', 'required' => FALSE));

		$categories = ORM::factory('Offer_Category')->get_list(1);
		$categories_select = array();
		$categories_select[NULL] = ___('offers.forms.advanced_search.category_all');

		foreach ($categories as $c) 
		{
			$categories_select[$c->category_id] = $c->category_name;
		}

		$this->add_select('category', $categories_select, array('required' => FALSE));
		
		$this->add_input_text('price_from', array('required' => FALSE))
			->add_filter('price_from', 'Bform_Filter_Float');
		
		$this->add_input_text('price_to', array('required' => FALSE))
			->add_filter('price_to', 'Bform_Filter_Float');
		
		$this->add_input_submit(___('form.search'));

		$this->template('site');
		
		$this->param('save_get_values', FALSE);
	}

}
