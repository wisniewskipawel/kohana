<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Exception extends Exception {

	/**
	 * In this var we are storing an information if stop validating
	 * 
	 * @var bool
	 */
	protected $_stop_validating = FALSE;

	/**
	 * Stored array with "driver_name" and "message" keys
	 * 
	 * @var array
	 */
	protected $_error = array();

	public function __construct(array $error, $stop_validating)
	{
		parent::__construct('Validation error', 37);
		$this->_error = $error;
		$this->_stop_validating = $stop_validating;
	}

	/**
	 * Getter
	 * 
	 * @return bool
	 * @see Bform_Validator_Exception::$_stop_validating
	 */
	public function stop()
	{
		return $this->_stop_validating;
	}

	/**
	 * Getter
	 * 
	 * @return array
	 */
	public function error() 
	{
		return $this->_error;
	}

}
