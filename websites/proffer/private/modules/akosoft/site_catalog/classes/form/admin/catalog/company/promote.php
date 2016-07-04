<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Company_Promote extends Bform_Form {

	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'catalog');
		$this->form_data($params);
		
		$this->add_bool('company_is_promoted');
		
		$this->add_datetime('company_promotion_availability', array('required' => FALSE));
		
		$this->add_input_submit(___('form.save'));
	}

}
