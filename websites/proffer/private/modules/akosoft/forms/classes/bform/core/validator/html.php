<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Html extends Bform_Validator_Base {

	public function validate() 
	{
		$length = UTF8::strlen($this->_value);
		$lenth2 = UTF8::strlen(strip_tags($this->_value));

		if ($length != $lenth2) 
		{
			$this->_error = 'bform.validator.html';
			$this->exception();
		}
	}
	
}
