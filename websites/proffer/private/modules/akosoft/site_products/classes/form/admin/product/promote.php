<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Product_Promote extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'products.forms');

		$params['product_promotion_availability'] = date('Y-m-d H:i:s', strtotime('now + 2 weeks'));
		$this->form_data($params);
		
		$this->add_datetime('product_availability');
		
		$this->add_select('product_distinction', products::distinctions(), array('required' => FALSE));
		
		$this->add_datetime('product_promotion_availability', array('required' => FALSE));
			
		$this->add_input_submit(___('form.save'));
	}

}
