<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Collection_Flat extends Bform_Driver_Collection {
	
	protected $_options = array(
		'decorate' => TRUE,
		'form' => NULL,
		'get_values_path' => '',
		'set_values_path' => '',
	);
	
}