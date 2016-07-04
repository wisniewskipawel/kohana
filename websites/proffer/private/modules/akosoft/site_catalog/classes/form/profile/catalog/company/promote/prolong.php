<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Profile_Catalog_Company_Promote_Prolong extends Bform_Form {
	
	public function create(array $params = array())
	{
		$current_user = $params['current_user'];
		$payment_module = $params['payment_module'];
		$company = $params['company'];
		$promotion_type = $company->promotion_type;
		
		$this->add_payments('payments', $payment_module, array(
			'payment_type' => $promotion_type,
			'discount' => $current_user->data->catalog_discount,
		));

		 $this->add_input_submit(___('form.next'));
		 
		 $this->template('site');
	}
	
}