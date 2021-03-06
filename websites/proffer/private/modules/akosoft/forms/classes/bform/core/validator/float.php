<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Float extends Bform_Validator_Base {

	public function validate() 
	{
		if (strlen($this->_value)) 
		{
			$this->_value = str_replace(',', '.', $this->_value);

			if ( ! is_numeric($this->_value) || ! preg_match('/^[0-9]+\.[0-9]+$/', $this->_value)) 
			{
				$this->_error = 'bform.validator.float';
				$this->exception();
			}
		}
	}
	
}
