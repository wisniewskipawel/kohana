<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Reviews_Edit extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'catalog.reviews');
		
		$review = $params['review'];
		$this->form_data($review->as_array());
		
		$this->add_input_email('email');
		
		$this->add_select('rating', array('', 1, 2, 3, 4, 5));
		
		$this->add_textarea('comment_body', array('required' => FALSE))
			->add_validator('comment_body', 'Bform_Validator_Html');
		
		$this->add_input_text('comment_author', array('required' => FALSE))
			->add_validator('comment_author', 'Bform_Validator_Html');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
