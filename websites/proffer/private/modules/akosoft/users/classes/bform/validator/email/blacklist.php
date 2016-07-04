<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Validator_Email_Blacklist extends Bform_Validator_Base {
	
	public function validate()
	{
		if($this->_value)
		{
			if(Model_Email_BlackList::check_email($this->_value))
			{
				$this->_error = ___('users.forms.validator.email.blacklist');
				$this->exception();
			}
		}
	}
	
}