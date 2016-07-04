<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Compare extends Bform_Validator_Base {
	
	/**
	 * Stores a value which we can compare
	 * 
	 * @var mixed
	 */
	protected $_compare_value = null;

	/**
	 * Stores a driver name which is used to retrieve sended value from that driver
	 * 
	 * @var string
	 */
	protected $_compare_driver_name = null;

	public function __construct(Bform_Driver_Common $driver, array $options = array())
	{
		if ( ! isset($options['msg'])) 
		{
			throw new Bform_Exception('You must enter "msg" value');
		}

		if ( ! isset($options['compare'])) 
		{
			throw new Bform_Exception('You must enter "compare" option: driver name');
		}

		$this->_error = $options['msg'];
		$this->_compare_driver_name = $options['compare'];

		unset($options['compare'], $options['msg']);

		parent::__construct($driver, $options);
	}

	/**
	 * 
	 */
	public function update() 
	{
		parent::update();

		$form = $this->_driver->data('form');
		$driver = Arr::path($form, $this->_compare_driver_name);

		if ( ! $driver) 
		{
			throw new Bform_Exception("Driver {$this->_compare_driver_name} doesnt exists!");
		}
		$this->_compare_value = $driver->get_value();
	}

	/**
	 *
	 * @throw Bform_Validator_Exception
	 */
	public function validate()
	{
		if ($this->_compare_value != $this->_value) {
			$this->exception();
		}
	}
	
}
