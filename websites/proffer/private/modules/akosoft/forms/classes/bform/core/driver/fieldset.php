<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Fieldset extends Bform_Driver_Collection {
	
	protected $_options = array(
		'decorate' => TRUE,
		'form' => NULL,
		'fieldset' => TRUE,
		'set_values_path' => '',
		'get_values_path' => '',
	);
	
}