<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Driver_DatePicker extends Bform_Driver_DateTime {
	
	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		$options = Arr::merge(array(
			'time' => FALSE,
			'format' => 'Y-m-d',
		), $options);
		
		parent::__construct($form, $name, $options);
	}
	
}
