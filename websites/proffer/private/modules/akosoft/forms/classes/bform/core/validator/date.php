<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Validator_Date extends Bform_Validator_Base {

	public function validate() 
	{
		if(empty($this->_value)) 
		{
			return TRUE;
		}
		
		$value = strtotime($this->_value);
		
		if($value === FALSE)
		{
			$this->_error = 'bform.validator.date.invalid';
			$this->exception();
		}
		
		if(!empty($this->_options['from']) AND $value < strtotime($this->_options['from']))
		{
			$this->_error = ___("bform.validator.date.from", $this->_get_options());
			$this->exception();
		}

		if(!empty($this->_options['to']) AND $value > strtotime($this->_options['to']))
		{
			$this->_error = ___("bform.validator.date.to", $this->_get_options());
			$this->exception();
		}
	}
	
}
