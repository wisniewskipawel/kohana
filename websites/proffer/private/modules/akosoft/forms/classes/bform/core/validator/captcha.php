<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Captcha extends Bform_Validator_Base {

	public function validate() 
	{
		if ( ! Captcha::valid($this->_value)) 
		{
			$this->_error = 'bform.validator.captcha';
			$this->exception();
		}
		return TRUE;
	}
	
}
