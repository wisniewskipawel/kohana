<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Promote extends Bform_Form {

	public function create(array $params = array()) 
	{
		$values = $params['offer']->as_array();
		$values['offer_promotion_availability'] = date('Y-m-d H:i:s', strtotime('now + 2 weeks'));
		
		$this->form_data($values);
		
		$this->param('i18n_namespace', 'offers.forms');
		
		$select = offers::distinctions();
		$this->add_select('offer_distinction', $select, array('label' => 'Rodzaj promocji'));
		
		$this->add_datetime('offer_promotion_availability');
		
		$this->add_datetime('offer_availability');
		
		$this->add_input_submit(___('form.save'));
	}

}
