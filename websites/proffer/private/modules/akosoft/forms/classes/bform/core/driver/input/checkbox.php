<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Input_Checkbox extends Bform_Driver_Common {

	/**
	 *  Additional fields in data containers
	 * 
	 * @access public
	 * @var array
	 */
	public $_custom_data = array(
		'_html'     => array(
			'checked'  => FALSE,
		),
	);
	
	public function __construct(Bform_Core_Form $form, $name, $value, array $info = array())
	{
		$info['row_class'] = 'input-chbox '.Arr::get($info, 'row_class');
		$info['checked'] = isset($info['value']) AND $info['value'];
		$info['value'] = $value;
		
		parent::__construct($form, $name, $info);
	}
	
	public function get_value()
	{
		return $this->html('checked') ? parent::get_value() : NULL;
	}
	
	public function set_value($value)
	{
		return $this->html('checked', !!$value);
	}
	
	public function set_values($values)
	{
		$this->set_value(Arr::path($values, $this->data('path'), FALSE));
	}
	
	public function on_get_values($values, $not_empty = FALSE)
	{
		$this->execute_filters();
		$value = $this->get_value();
		
		if(!$value)
			return $values;

		if(!Valid::not_empty($value) AND $not_empty === TRUE)
			return $values;

		$values[$this->data('name')] = $value;
		
		return $values;
	}
	
}
