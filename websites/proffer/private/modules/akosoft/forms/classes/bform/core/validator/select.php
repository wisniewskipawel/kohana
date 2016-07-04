<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Select extends Bform_Validator_Base {
    
	protected $_possible_values = array();
	protected $_error = 'bform.validator.select';

	public function validate() 
	{
		if ( ! in_array($this->_value, $this->_possible_values)) 
		{
			$this->exception();
		}
	}

	public function update() 
	{
		parent::update();
		$this->_possible_values = $this->_driver->html('options');
	}
	
}
