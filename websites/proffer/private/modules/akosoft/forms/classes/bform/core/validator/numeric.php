<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Numeric extends Bform_Validator_Base {

	public function validate() 
	{
		if (empty($this->_value)) 
		{
			return;
		}
		
		$this->_value = str_replace(',', '.', $this->_value);
		
		if ( ! is_numeric($this->_value)) 
		{
			$this->_error = 'bform.validator.numeric';
			$this->exception();
		}
	}

}
