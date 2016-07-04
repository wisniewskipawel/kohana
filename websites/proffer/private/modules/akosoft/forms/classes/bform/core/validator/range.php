<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Range extends Bform_Validator_Base {

	public function __construct(Bform_Driver_Common $driver, array $options = array()) 
	{   
		if ( ! isset($options['min']) )
		{
			$options['min'] = FALSE;
		}
		if ( ! isset($options['max']))
		{
			$options['max'] = FALSE;
		}

		parent::__construct($driver, $options);
	}

	public function validate() 
	{
		if (empty($this->_value) AND !$this->_driver->data('required')) 
		{
			return TRUE;
		}

		$this->_value = str_replace(',', '.', $this->_value);

		if ( ! is_numeric($this->_value)) 
		{
			$this->_error = 'bform.validator.numeric';
			$this->exception();
		}
		
		if ($this->_options['min'] !== FALSE AND $this->_value < $this->_options['min'])
		{
			$this->_error = ___("bform.validator.range.min", (int)$this->_options['min'], $this->_get_options());
			$this->exception();
		}

		if ($this->_options['max'] !== FALSE AND $this->_value > $this->_options['max']) 
		{
			$this->_error = ___("bform.validator.range.max", (int)$this->_options['max'], $this->_get_options());
			$this->exception();
		}
	}
	
}
