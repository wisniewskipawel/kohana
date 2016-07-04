<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Dependency extends Bform_Validator_Base {

	private $_dependencies_values = array();
	private $_dependencies_values_from_drivers = array();
	private $_dependencies_drivers_names = array();

	public function __construct(Bform_Driver_Common $driver, array $options = array()) 
	{
		if ( ! isset($options['dependencies_drivers_names'])) 
		{
			throw new Bform_Exception('You must enter dependency driver name!');
		}

		if ( ! is_array($options['dependencies_drivers_names'])) 
		{
			throw new Bform_Exception('Dependencies drivers name must be an array!');
		}
		$this->_dependencies_drivers_names = $options['dependencies_drivers_names'];

		if (isset($options['dependencies_values'])) 
		{
			$this->_dependencies_values = $options['dependencies_values'];
		}

		unset($options['dependencies_drivers_names'], $options['dependencies_values']);

		parent::__construct($driver, $options);
	}

	public function update() 
	{
		parent::update();

		$dependencies_drivers_names = $this->_dependencies_drivers_names;
		$dependencies_values = array();
		
		$values = $this->_driver->form()->get_values();
		
		foreach ($dependencies_drivers_names as $driver_name) 
		{
			$dependencies_values[$driver_name] = Arr::path($values, $driver_name);
		}

		$this->_dependencies_values_from_drivers = $dependencies_values;
	}

	public function get_dependencies_values() 
	{
		return $this->_dependencies_values;
	}

	public function get_dependencies_drivers_names() 
	{
		return $this->_dependencies_drivers_names;
	}

	public function get_dependencies_values_from_drivers() 
	{
		return $this->_dependencies_values_from_drivers;
	}
}
