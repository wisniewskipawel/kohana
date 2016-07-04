<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Input_Hidden extends Bform_Driver_Common {
	
	public $_custom_data = array(
		'_data'     => array(
			'required' => FALSE
		),
		'_html' => array(
			'no_decorate' => TRUE,
		),
	);
	
	public function __construct(Bform_Core_Driver_Collection $form, $name, $value, array $options = array())
	{
		$options['value'] = $value;
		parent::__construct($form, $name, $options);
	}
	
}
