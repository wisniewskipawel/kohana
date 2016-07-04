<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Category_Add extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms.categories');
		
		$this->add_input_text('category_name', array());
		
		$this->add_textarea('category_meta_description', array('required' => FALSE));
		
		$this->add_textarea('category_meta_keywords', array('required' => FALSE));
		
		$this->add_input_text('category_meta_robots', array('required' => FALSE));
		
		$this->add_input_text('category_meta_revisit_after', array('required' => FALSE));
		
		$this->add_input_text('category_meta_title', array());
		
		$this->add_textarea('category_text', array('required' => FALSE));
		
		$this->add_bool('category_age_confirm', array());

		$this->add_input_file('image', array(
			'html_before' => ___('offers.forms.categories.image_info'),
			'required' => FALSE,
		))
			->add_validator('image', 'Bform_Validator_File_Filesize', array('filesize' => '1M'))
			->add_validator('image', 'Bform_Validator_File_Image');

		$this->add_input_submit(___('form.save'));
	}

}
