<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Validator_ORM_Categories extends Bform_Validator_Base {

	public function validate() 
	{
		if (!empty($this->_value)) 
		{
			if(!$this->_driver->data('allow_only_parent'))
			{
				if(!$this->_driver->validate_allow_only_parent())
				{
					$this->_error = 'bform.validator.orm.categories.allow_only_parent';
					$this->exception();
				}
			}
		}
	}
	
}
