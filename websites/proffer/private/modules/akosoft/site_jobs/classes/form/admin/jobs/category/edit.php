<?php/*** @author	AkoSoft Team <biuro@akosoft.pl>* @link		http://www.akosoft.pl* @copyright	Copyright (c) 2014, AkoSoft*/class Form_Admin_Jobs_Category_Edit extends Bform_Form {		public function create(array $params = array()) 	{		$category = $params['category'];				$this->form_data($category->as_array());				$this->add_input_text('category_name');				$this->add_input_text('category_meta_title', array('required' => FALSE));		$this->add_textarea('category_meta_description', array('required' => FALSE));		$this->add_textarea('category_meta_keywords', array('required' => FALSE));		$this->add_input_text('category_meta_robots', array('required' => FALSE));		$this->add_input_text('category_meta_revisit_after', array('required' => FALSE));				if($category->category_level == 2)		{			$image = $category->get_image();						if($image)			{				$this->add_html(					HTML::image($image, array('style' => 'max-width:100px')).					HTML::anchor('admin/job/categories/delete_image/'.$category->pk(), ___('jobs.admin.categories.forms.delete_image'))				);			}						$this->add_input_file('image', array('label' => 'jobs.admin.categories.forms.image', 'required' => FALSE))				->add_validator('image', 'Bform_Validator_File_Image');		}				$this->add_input_submit('Zapisz');	}	}