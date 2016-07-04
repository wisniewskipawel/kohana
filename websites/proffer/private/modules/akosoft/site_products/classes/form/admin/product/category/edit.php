<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Form_Admin_Product_Category_Edit extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		/** @var Model_Catalog_Category $category */
		$category = $params['category'];

		$this->form_data($category->as_array());
		
		$this->add_tab('general', ___('products.admin.categories.forms.add.general_tab'));
		
		$this->general->add_input_text('category_name');

		if($category->category_level == 2)
		{
			$icon_path = $category->get_icon_uri();

			if($icon_path)
			{
				$this->general->add_html(
					HTML::image($icon_path, array('style' => 'max-width:100px')).
					HTML::anchor(
						'admin/product/categories/delete_icon/'.$category->pk(),
						$this->trans('products.admin.categories.forms.delete_icon')
					)
				);
			}

			$this->general->add_input_file('icon', array('label' => $this->trans('products.admin.categories.forms.icon'), 'required' => FALSE))
				->add_validator('icon', 'Bform_Validator_File_Image');
		}
		
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
