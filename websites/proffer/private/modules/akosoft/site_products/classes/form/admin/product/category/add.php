<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Form_Admin_Product_Category_Add extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_tab('general', ___('products.admin.categories.forms.add.general_tab'));
		
		$select = (new Model_Product_Category())->get_select();
		$this->general->add_select('category_parent_id', $select);
		
		$this->general->add_input_text('category_name');
		
		$this->add_tab('seo', ___('products.admin.categories.forms.add.seo'));
		
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
