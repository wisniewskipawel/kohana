<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Bform_Core_Filter_Base {

	protected $_value = NULL;
	protected $_options = array();
	protected $_driver = NULL;

	public function __construct(Bform_Driver_Common & $driver, array $options = array())
	{
		$this->_driver = $driver;
		$this->_options = $options;
	}

	public function update() 
	{
		$this->_value = $this->_driver->get_value();
	}

}
