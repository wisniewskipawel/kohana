<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_ORM_Unique extends Bform_Validator_Base {

	public function validate() 
	{
		if (!empty($this->_value)) 
		{
			if(!isset($this->_options['field']))
			{
				$this->_options['field'] = $this->_driver->data('name');
			}
			
			if(!$this->_options['model']->unique($this->_options['field'], $this->_value))
			{
				$this->_error = 'bform.validator.orm.unique';
				$this->exception();
			}
		}
	}
	
}
