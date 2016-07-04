<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Textarea extends Bform_Driver_Common {

	public $_custom_data = array(
		'_data' => array(
			'chars_counter' => NULL,
		),
		'_html' => array(
			'rows' => 10,
			'cols' => 50,
		),
	);

}
