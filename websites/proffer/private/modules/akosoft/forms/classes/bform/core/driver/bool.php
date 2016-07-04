<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Bool extends Bform_Driver_Input_Checkbox {

	public function __construct(Bform_Core_Form $form, $name, array $info = array())
	{
		if(!isset($info['required']))
		{
			$info['required'] = FALSE;
		}
		
		parent::__construct($form, $name, '1', $info);
	}
	
	public function get_value()
	{
		return (bool)$this->html('checked');
	}
	
	public function on_get_values($values, $not_empty = FALSE)
	{
		$this->execute_filters();

		$values[$this->data('name')] = $this->get_value();
		
		return $values;
	}
	
}
