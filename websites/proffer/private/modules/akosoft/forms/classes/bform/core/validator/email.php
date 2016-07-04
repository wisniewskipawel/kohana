<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Email extends Bform_Validator_Base {
	
	public function validate() 
	{
		if(!Valid::not_empty($this->_value))
			return TRUE;
		
		if(!Valid::email($this->_value))
		{
			$this->_error = 'bform.validator.email';
			$this->exception();
		}
		
		return TRUE;
	}
	
}
