<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Length extends Bform_Validator_Base {
    
	public function __construct(Bform_Driver_Common $driver, array $options = array()) 
	{
		if ( ! isset($options['min']))
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
		$length = utf8::strlen($this->_value);

		if ($this->_options['min'] !== FALSE AND $length < $this->_options['min']) 
		{
			$this->_error = ___("bform.validator.length.min", (int)$this->_options['min'], $this->_get_options());
			$this->exception();
		}

		if ($this->_options['max'] !== FALSE AND $length > $this->_options['max']) 
		{
			$this->_error = ___("bform.validator.length.max", (int)$this->_options['max'], $this->_get_options());
			$this->exception();
		}
	}
	
}
