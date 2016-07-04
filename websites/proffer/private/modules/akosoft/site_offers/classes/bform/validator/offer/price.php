<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Validator_Offer_Price extends Bform_Validator_Dependency {

	public function validate() 
	{
		$values = $this->get_dependencies_values_from_drivers();
		
		if (empty($this->_value))
		{
			return;
		}

		if ($this->_value < 0)
		{
			$this->_error = ___('offers.forms.validator.offer.price.invalid');
			$this->exception();
		}

		if ($this->_value >= $values['offer_price_old'])
		{
			$this->_error = ___('offers.forms.validator.offer.price.error');
			$this->exception();
		}
	}

}