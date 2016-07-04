<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Product_Renew extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'products.forms');
		
		$this->form_data($params['product']->as_array());
		
		$this->add_datetime('product_availability');
		
		$this->add_input_submit(___('form.save'));
	}

}
