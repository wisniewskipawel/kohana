<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Input_Range extends Bform_Driver_Input {

	public $_custom_data = array(
		'_data'         => array(
			'from_name'          => '',
			'to_name' => '',
			'driver_template' => 'bform/shared/drivers/input/range',
		),
		'_html' => array(
			'row_class' => 'input_range',
			'class' => 'half',
		),
	);

	public function __construct(Bform_Form $form, $name, array $info = array())
	{
		$info['from_name'] = $name.'_from';
		$info['to_name'] = $name.'_to';
		
		parent::__construct($form, $name, $info);
	}
	
	public function get_value()
	{
		$form = $this->data('form');
		
		$values = $form->method() == 'post' ? Request::current()->post() : Request::current()->query();
		
		return array(
			'from' => Arr::get($values, $this->data('from_name')), 
			'to' => Arr::get($values, $this->data('to_name')),
		);
	}

}
