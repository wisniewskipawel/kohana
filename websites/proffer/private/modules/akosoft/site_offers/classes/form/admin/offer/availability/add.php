<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Availability_Add extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'offers.forms');
		
		$this->form_data($params);
		
		$this->add_input_text('availability')
			->add_validator('availability', 'Bform_Validator_Integer');
		
		$this->add_input_submit(___('form.save'));
	}

}
