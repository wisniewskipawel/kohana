<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Category_Add extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_tab('general', ___('catalog.admin.forms.category.add.general_tab'));
		
		$select = ORM::factory('Catalog_Category')->get_select_tree();
		$this->general->add_select('category_parent_id', $select);
		
		$this->general->add_input_text('category_name');
		
		$this->add_tab('seo', ___('catalog.admin.forms.category.add.seo'));
		
		$this->seo->add_input_text('category_meta_title', array('required' => FALSE))
			->add_validator('category_meta_title', 'Bform_Validator_Length', array('min' => 0, 'max' => 64));
		
		$this->seo->add_textarea('category_meta_description', array('required' => FALSE))
			->add_validator('category_meta_description', 'Bform_Validator_Length', array('min' => 0, 'max' => 256));
		
		$this->seo->add_textarea('category_meta_keywords', array('required' => FALSE))
			->add_validator('category_meta_keywords', 'Bform_Validator_Length', array('min' => 0, 'max' => 256));
		
		$this->seo->add_input_text('category_meta_robots', array('required' => FALSE));
		
		$this->add_input_submit(___('form.save'));
	}

}
