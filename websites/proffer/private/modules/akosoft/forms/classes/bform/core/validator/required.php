<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Required extends Bform_Validator_Base {

	public function validate() 
	{
		$this->_error = 'bform.validator.required';
		
		if (!Valid::not_empty($this->_value)) 
		{
			$this->exception();
		}
		
		if($this->_driver instanceof Bform_Core_Driver_Input_File)
		{
			if(!Upload::not_empty($this->_value))
			{
				$this->exception();
			}
		}
		
	}
	
}
