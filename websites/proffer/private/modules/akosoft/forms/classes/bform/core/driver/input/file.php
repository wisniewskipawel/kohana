<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Input_File extends Bform_Driver_Common {
    
	public function get_value()
	{
		return Arr::get($_FILES, $this->html('name'));
	}
	
	protected function _get_html_option($name, $default = NULL)
	{
		if($name == 'name')
		{
			return str_replace('.', '_', $this->data('path'));
		}
		else
		{
			return parent::_get_html_option($name, $default);
		}
	}
	
	public function on_get_values($values, $not_empty = FALSE)
	{
		return $values;
	}
	
}
