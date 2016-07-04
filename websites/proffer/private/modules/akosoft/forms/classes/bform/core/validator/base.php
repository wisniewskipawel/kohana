<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Base implements Bform_Validator_Interface {
    
	/**
	 * Sended value
	 * 
	 * @var mixed
	 */
	protected $_value = '';

	/**
	 * A message what gone wrong
	 * 
	 * @var string
	 */
	protected $_error = '';

	/**
	 * Additional params passed thru add_validator() method
	 * 
	 * @see Bform_Form::add_validator()
	 * @var array
	 */
	protected $_options = array();

	/**
	 * A driver belong to instance of Bform_Validator_*
	 * 
	 * @var Bform_Driver_Common 
	 * @access protected
	 */
	protected $_driver = NULL;

	public function __construct(Bform_Driver_Common $driver, array $options = array())
	{
		$this->_options = $options;
		$this->_driver = $driver;
	}

	/**
	 * Updates a value to validate
	 * 
	 * @access public
	 * @see Bform_Form::validate()
	 */
	public function update() 
	{
		$this->_value = $this->_driver->get_value();
	}

	/**
	 * Validates a value. This method should be extended in your own validator
	 * 
	 * @return void
	 */
	public function validate() 
	{
		throw new Bform_Exception('You must extend this method in your validator!');
	}

	/**
	 * Throws a Bform_Validator_Exception, changes driver class and mark driver as having an error 
	 * 
	 * @throws Bform_Validator_Exception
	 * @final
	 */
	public function exception($stop_validating = TRUE) 
	{
		throw new Bform_Validator_Exception(array(
			'driver_name' => $this->_driver->html('name'), 
			'label' => $this->_driver->html('label'), 
			'message' => ___($this->_error, $this->_get_options()),
		), $stop_validating);
	}

	protected function _get_options()
	{
		$new_vars = array();

		foreach ($this->_options as $name => $value) 
		{
			if (!is_scalar($value))
			{
				continue;
			}

			if ($name[0] == '_') 
			{
				$name = substr($name, 1);
			}

			$name = ':' . $name;
			$new_vars[$name] = $value;
		}
		
		if(is_scalar($this->_value))
		{
			$new_vars[':value'] = $this->_value;
		}
		return $new_vars;
	}
	
}
