<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Manager_Group {
    
	protected $_current_group = NULL;
	protected $_started = FALSE;
	protected $_saved_value = NULL;
	protected $_form = NULL;

	public function started($val = NULL) 
	{
		if ($val === NULL) 
		{
			return $this->_started;
		}
		
		if ( ! is_bool($val)) 
		{
			throw new Bform_Exception('check api!');
		}
		$this->_started = $val;
	}

	public function current_group(Bform_Driver_Group $group = NULL) 
	{
		if ($group === NULL) 
		{
			if ($this->_current_group === NULL) 
			{
				throw new Bform_Exception('group is not started!');
			}
			return $this->_current_group;
		}
		$this->_current_group = $group;
	}

	public function clear() 
	{
		$this->_current_group->refresh();
		$this->_current_group = NULL;
		$this->_started = FALSE;
	}

	public function add_driver(array $values) 
	{
		if (empty($values[0])) 
		{
			throw new Bform_Exception('You must pass a label of the element!');
		}

		if (empty($values[1])) 
		{
			throw new Bform_Exception('You must pass a value of the driver!');
		}

		if (isset($values[2]) AND ! is_array($values[2])) 
		{
			throw new Bform_Exception('Driver values must be an array!');
		}

		if (isset($values[2]) AND is_array($values[2]))
		{
			$info = $values[2];
		} 
		else 
		{
			$info = array();
		}

		$label = $values[0];
		$value = $values[1];
		$info['label'] = $label;
		$info['value'] = $value;
		$info['required'] = $this->_current_group->data('required');
		$info['parent'] = & $this->_current_group;

		if ($this->_current_group->data('is_array') === TRUE) 
		{
			$driver = Bform_Driver_Group_Checkbox::factory($this->_current_group->data('form'), $this->_current_group->html('name'), $info);
		} 
		else
		{
			$driver = Bform_Driver_Group_Radio::factory($this->_current_group->data('form'), $this->_current_group->html('name'), $info);
		}

		$this->_current_group->data('elements', $driver);
	}

}
