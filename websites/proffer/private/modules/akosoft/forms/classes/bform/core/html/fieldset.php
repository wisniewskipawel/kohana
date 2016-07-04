<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Html_Fieldset {
    
	protected $_legend = NULL;
	protected $_depth = 0;
	protected $_after_driver_name;
	protected $_key = NULL;

	protected $_drivers = array();
	protected $_contains_drivers = array();

	protected $_children = array();
	protected $_parents = array();

	public static function factory() 
	{
		return new Bform_Html_Fieldset;
	}

	public function key($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_key;
		}
		$this->_key = $value;
		return $this;
	}

	public function after($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_after_driver_name;
		}
		$this->_after_driver_name = $value;
		return $this;
	}

	public function legend($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_legend;
		}
		$this->_legend = $value;
		return $this;
	}

	public function & children()
	{
		return $this->_children;
	}

	public function parents($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_parents;
		}
		$this->_parents = $value;
		$this->_depth = count($this->_parents) + 1;
		return $this;
	}

	public function drivers()
	{
		return $this->_drivers;
	}

	public function depth()
	{
		return $this->_depth;
	}

	public function append_driver($driver_name)
	{
		$this->_drivers[] = $driver_name;
		$this->_contains_drivers[] = $driver_name;
		foreach ($this->_parents as $p)
		{
			$p->_contains_drivers[] = $driver_name;
		}
	}

	public function append_fieldset(Bform_Html_Fieldset & $fieldset)
	{
		$new_key = count($this->_children);
		$this->_children[] = $fieldset->key($new_key);
	}

	public function has_parents()
	{
		return (bool) count($this->_parents);
	}

	public function has_children()
	{
		return (bool) count($this->_children);
	}

	public function has_drivers()
	{
		return (bool) count($this->_drivers);
	}

	public function has_children_after($driver_name)
	{
		if ( ! $this->has_children())
		{
			return FALSE;
		}
		foreach ($this->_children as $fieldset)
		{
			if ($fieldset->after() == $driver_name)
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function has_drivers_after($driver_name)
	{
		$key = array_search($driver_name, $this->_drivers);
		if ($key === FALSE)
		{
			return FALSE;
		}
		return isset($this->_drivers[$key + 1]);
	}

	public function contains_drivers_after($driver_name)
	{
		$key = array_search($driver_name, $this->_contains_drivers);
		if ($key === FALSE)
		{
			return FALSE;
		}
		return isset($this->_contains_drivers[$key + 1]);
	}

	public function has_driver($driver_name)
	{
		return in_array($driver_name, $this->_drivers);
	}

	public function up($level = 1)
	{
		if ( ! $this->has_parents())
		{
			throw new Bform_Exception('Fieldset has no parents! Use "has_parents" method to check if any exists!');
		}
		$level--;
		$last_parent_key = count($this->_parents) - 1;
		$leveled_parent_key = $last_parent_key - $level;
		if ( ! isset($this->_parents[$leveled_parent_key]))
		{
			throw new Bform_Exception("Fieldset do not have parent in that level up!");
		}
		return $this->_parents[$leveled_parent_key];
	}

	public function next()
	{
		$parent = $this->up();
		return $parent->get_child_by_key($this->_key + 1);
	}

	public function get_child_by_key($key)
	{
		if ($key === NULL)
		{
			return NULL;
		}
		if ( ! isset($this->_children[$key]))
		{
			return NULL;
		}
		return $this->_children[$key];
	}

	public function get_last_parent()
	{
		if ( ! $this->has_parents())
		{
			throw new Bform_Exception('Fieldset has not a parents! Use "has_parents" method to check!');
		}
		if (isset($this->_parents[0]))
		{
			return $this->_parents[0];
		}
		return NULL;
	}

	public function is_child_last(Bform_Html_Fieldset $fieldset)
	{
		$last_key = count($this->_children) - 1;
		foreach ($this->_children as $key => $c)
		{
			if ($c->legend() == $fieldset->legend() AND $key === $last_key)
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function is_driver_last($driver_name)
	{
		$last_key = count($this->_drivers) - 1;
		foreach ($this->_drivers as $key => $name)
		{
			if ($name == $driver_name AND $last_key == $key)
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function has_empty_parent()
	{
		$result = array();
		foreach ($this->_parents as $fieldset)
		{
			if ( ! count($fieldset->drivers()))
			{
				$result[] = TRUE;
			}
			else
			{
				$result[] = FALSE;
			}
		}
		$result = array_unique($result);
		if (count($result) === 1 AND in_array(TRUE, $result))
		{
			return TRUE;
		}
		return FALSE;
	}

	public function find_child_with_driver($driver_name, & $result = FALSE)
	{
		if ($result !== FALSE)
		{
			return;
		}
		if ($this->has_driver($driver_name))
		{
			return $this;
		}
		foreach ($this->_children as $c)
		{
			if ($c->has_driver($driver_name))
			{
				$result = $c;
				return $result;
			}
			$c->find_child_with_driver($driver_name, $result);
		}
		return $result;
	}
    
}
