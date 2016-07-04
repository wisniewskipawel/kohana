<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
interface Bform_Core_Validator_Interface {

	public function __construct(Bform_Driver_Common $driver, array $options = array());

	public function validate();
}
