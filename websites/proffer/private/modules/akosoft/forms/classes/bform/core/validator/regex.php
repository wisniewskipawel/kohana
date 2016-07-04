<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Regex extends Bform_Validator_Base {
	
	protected $_regex = '';

	public function __construct(Bform_Driver_Common $driver, array $options = array()) 
	{
		if ( ! isset($options['regex'])) 
		{
			throw new Bform_Exception('You must enter "regex" value');
		}
		if ( ! isset($options['error'])) 
		{
			throw new Bform_Exception('You must enter "error" value');
		}

		$this->_regex = $options['regex'];
		$this->_error = $options['error'];
		unset($options['regex'], $options['msg']);

		parent::__construct($driver, $options);
	}

	public function validate() 
	{
		if (empty($this->_value)) 
		{
			return;
		}

		if ( ! preg_match($this->_regex, $this->_value))
		{
			$this->exception();
		}
	}
	
}
