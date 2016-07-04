<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Manager_Block {

	public $tabs_first_created = FALSE;
	protected $_tabs = array();
	protected $_tabs_current = NULL;

	protected $_drivers = array();
	protected $_last_driver_name = '';
	public $_fieldsets_collection = NULL;

	public function  __construct()
	{
		$this->_fieldsets_collection = new Bform_Html_Fieldset_Collection($this);
	}

	public function drivers($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_drivers;
		}
		$this->_drivers[] = $value;
		$this->_last_driver_name = $value;
	}

	public function drivers_get_next($driver_name) 
	{
		$key = array_search($driver_name, $this->_drivers);
		if ($key === FALSE) 
		{
			return FALSE;
		}
		$key++;
		if ( ! isset($this->_drivers[$key])) 
		{
			return FALSE;
		}
		return $this->_drivers[$key];
	}

	public function tabs_add($id, $label) 
	{
		if ($this->_fieldsets_collection->opened()) 
		{
			throw new Bform_Exception('You must close all fieldsets!');
		}
		$this->_tabs[$id] = array('id' => $id, 'label' => $label, 'drivers' => array());
		$this->_tabs_current = $id;
	}

	public function tabs_add_driver($driver_name) 
	{
		if ($this->_tabs_current !== NULL) 
		{
			$this->_tabs[$this->_tabs_current]['drivers'][] = $driver_name;
		}
	}

	public function fieldsets_add($legend) 
	{
		$this->_fieldsets_collection->add_fieldset($legend, $this->_last_driver_name);
	}

	public function fieldsets_add_driver($driver_name) 
	{
		$this->_fieldsets_collection->add_driver($driver_name);
	}

	public function fieldsets_clear() 
	{
		$this->_fieldsets_collection->clear();
	}

	public function fieldsets_get_to_open($driver_name) 
	{
		return $this->_fieldsets_collection->get_to_open($driver_name);
	}

	public function fieldsets_get_nb_to_close($driver_name) 
	{
		return $this->_fieldsets_collection->get_nb_to_close($driver_name);
	}

	public function tabs_get() 
	{
		return $this->_tabs;
	}

	public function tabs_is_driver_first($driver_name)
	{
		foreach ($this->_tabs as $id => $t)
		{
			$drivers = $t['drivers'];
			if (in_array($driver_name, $drivers))
			{
				foreach ($drivers as $key => $driver_name2)
				{
					if ($drivers[$key] == $driver_name && $key == 0)
					{
						return $this->_tabs[$id]['id'];
					}
				}
			}
		}
		return FALSE;
	}

	public function tabs_is_driver_last($driver_name)
	{
		if (empty($driver_name))
		{
			throw new Bform_Exception('driver name cannot be empty!');
		}

		foreach ($this->_tabs as $id => $t)
		{
			$drivers = $t['drivers'];
			if (in_array($driver_name, $drivers))
			{
				foreach ($drivers as $key => $driver_name2)
				{
					if ($drivers[$key] == $driver_name && $key == (count($drivers) - 1))
					{
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	public function tabs_close($driver_name)
	{
		return ($this->_last_driver_name == $driver_name AND count($this->_tabs) > 0);
	}

	public function tabs_open()
	{
		return (count($this->_tabs) > 0);
	}
	
}
