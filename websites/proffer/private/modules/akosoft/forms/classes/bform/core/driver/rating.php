<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Rating extends Bform_Driver_Base {

	public $_custom_data = array(
		'_data' => array(
			'max_rating' => 5,
		),
		'_html' => array(
			'row_class' => 'middle',
		),
	);

}
