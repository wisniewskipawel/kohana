<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Product_Type_Add extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_input_text('name', array('label' => 'products.forms.types.name'))
			->add_validator('name', 'Bform_Validator_ORM_Unique', array(
				'model' => ORM::factory('Product_Type'),
				'field' => 'name',
			));
		
		$this->add_input_submit(___('form.save'));
	}

}
