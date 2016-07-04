<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Coupons_Amount extends Bform_Validator_Dependency {

	public function validate() 
	{
		$values = $this->get_dependencies_values_from_drivers();
		
		$coupon = new Model_Coupon_Owner;
		$user_limit = $coupon->get_user_limit($this->_options['offer'], $values['email']);
		
		if (empty($this->_value) OR !$user_limit)
		{
			return;
		}

		if ($this->_value > $user_limit)
		{
			$this->_error = ___('offers.forms.validator.amount.user_limit', array(':nb' => $user_limit));
			$this->exception();
		}

		if ($this->_value > $this->_options['offer']->get_limit())
		{
			$this->_error = 'offers.forms.validator.amount.error';
			$this->exception();
		}
	}

}