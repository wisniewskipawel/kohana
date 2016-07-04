<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Html_Fieldset_Collection {

	protected $_current_fieldset = FALSE;
	protected $_fieldsets = array();
	protected $_fieldsets_opened = array();
	protected $_block_manager = NULL;

	public function __construct(Bform_Manager_Block $block_manager)
	{
		$this->_block_manager = $block_manager;
	}

	public function add_fieldset($legend, $after_driver_name)
	{
		$fieldset = Bform_Html_Fieldset::factory()->legend($legend)->parents($this->_fieldsets_opened)->after($after_driver_name);
		if ($this->_current_fieldset !== FALSE)
		{
			$this->_search_fieldset($this->_current_fieldset->legend(), $parent);
			$parent->append_fieldset($fieldset);
		}
		else
		{
			$fieldset->key(count($this->_fieldsets));
			$this->_fieldsets[] = $fieldset;
		}
		$this->_current_fieldset = $fieldset;
		$this->_fieldsets_opened[] = $fieldset;
	}

	public function opened()
	{
		return count($this->_fieldsets_opened) > 0;
	}

	public function add_driver($driver_name)
	{
		if ( ! $this->opened())
		{
			return;
		}
		$this->_current_fieldset->append_driver($driver_name);
	}

	public function clear()
	{
		array_pop($this->_fieldsets_opened);
		$this->_current_fieldset = end($this->_fieldsets_opened);
	}

	public function get_to_open($driver_name)
	{
		$this->_search_fieldset_containing_driver_first_position($driver_name, $fieldset);
		if ($fieldset !== NULL)
		{
			$fieldsets_to_open = Bform_Helper::array_diff_object($fieldset->parents(), $this->_fieldsets_opened);
			if ( ! Bform_Helper::in_array('legend', $fieldset, $this->_fieldsets_opened))
			{
				$fieldsets_to_open[] = $fieldset;
			}
			foreach ($fieldsets_to_open as $f)
			{
				$this->_fieldsets_opened[] = $f;
			}
			return $fieldsets_to_open;
		}
		return FALSE;
	}

	public function get_nb_to_close($driver_name)
	{
		$data['driver_name'] = $driver_name;
		$data['fieldsets_to_close'] = 0;
		$data['max_depth'] = count($this->_fieldsets_opened);
		$this->_calculate_nb_to_close($data);
		for ($i = 1; $i <= $data['fieldsets_to_close']; $i++)
		{
			$this->clear();
		}
		return $data['fieldsets_to_close'];
	}

	protected function _calculate_nb_to_close(array & $data, array & $array = NULL)
	{
		if ($array === NULL)
		{
			$array = & $this->_fieldsets;
		}
		foreach ($array as $fieldset)
		{
			if (Bform_Helper::in_array('legend', $fieldset, $this->_fieldsets_opened))
			{
				if ($fieldset->has_driver($data['driver_name']))
				{ // fieldset zawiera drivera    
					if ($fieldset->depth() === $data['max_depth'])
					{ // mielony jest ostatni fieldset    
						if ($fieldset->is_driver_last($data['driver_name']))
						{ // driver jest ostatni w fieldsecie
							$data['fieldsets_to_close']++;

							if ($fieldset->has_parents() AND ! $fieldset->next() AND
									$fieldset->up()->has_driver($this->_block_manager->drivers_get_next($data['driver_name'])))
							{
								$data['fieldsets_to_close']--;    
							}

							if ($fieldset->has_parents() AND ! $fieldset->next() AND ! $fieldset->has_empty_parent())
							{
								$data['fieldsets_to_close']++;
								if ($fieldset2 = $fieldset->get_last_parent()->find_child_with_driver($this->_block_manager->drivers_get_next($data['driver_name'])))
								{
									$data['fieldsets_to_close'] = $data['fieldsets_to_close'] + ($fieldset->depth() - $data['fieldsets_to_close'] - $fieldset2->depth());
								}
							}

							if ($fieldset->has_parents() AND $parent = $fieldset->get_last_parent() AND
									! $parent->contains_drivers_after($data['driver_name']))
							{
								// FIX - liczymy bo dodanie 1 nie rozwiazuje sprawy - czasem zamkniecia sa dobrze policzone
								$data['fieldsets_to_close'] = $data['fieldsets_to_close'] + (count($this->_fieldsets_opened) - $data['fieldsets_to_close']);
							}

							if ($fieldset->has_children() AND ! ($fieldset->has_parents() AND $parent = $fieldset->get_last_parent() 
									AND ! $parent->contains_drivers_after($data['driver_name'])))
							{
								$data['fieldsets_to_close'] = 0;   
								if ( ! $fieldset->has_children_after($data['driver_name']))
								{
									$data['fieldsets_to_close'] = 1;
								}
							}

						}
						else
						{
							/*
							 * nie potrzebne (?)
							echo '3 (odejmujemy)';
							$data['fieldsets_to_close']--;
							*/
						}
						/*
						 * nie potrzebne (?)
						if ($fieldset->has_parents() AND $parent = $fieldset->up() AND ! $parent->is_child_last($fieldset)) {
							echo '2 (odejmujemy) ';
							$data['fieldsets_to_close']--;
						}
						*/
					}
				}

				if ( ! $fieldset->has_drivers() AND $fieldset->depth() < $data['max_depth'])
				{
					//$data['fieldsets_to_close']++;
				}
				$this->_calculate_nb_to_close($data, $fieldset->children());
			}
		}
	}

	protected function _search_fieldset_containing_driver($driver_name, & $result, array & $array = NULL)
	{
		if ($array === NULL)
		{
			$array = & $this->_fieldsets;
		}
		if ($result !== NULL)
		{
			return;
		}
		foreach ($array as & $fieldset)
		{
			foreach ($fieldset->drivers() as $name)
			{
				if ($name == $driver_name)
				{
					$result = $fieldset;
					return;
				}
			}
			$this->_search_fieldset_containing_driver_first_position($driver_name, $result, $fieldset->children());
		}
	}

	protected function _search_fieldset_containing_driver_first_position(& $driver_name, & $result, array & $array = NULL)
	{
		if ($array === NULL)
		{
			$array = & $this->_fieldsets;
		}
		if ($result !== NULL)
		{
			return;
		}
		foreach ($array as & $fieldset)
		{
			foreach ($fieldset->drivers() as $key => $name)
			{
				if ($name == $driver_name AND $key === 0)
				{
					$result = $fieldset;
					return;
				}
			}
			$this->_search_fieldset_containing_driver_first_position($driver_name, $result, $fieldset->children());
		}
	}

	protected function _search_fieldset($legend, & $result, array & $array = NULL)
	{
		if ($array === NULL)
		{
			$array = & $this->_fieldsets;
		}
		if ($result !== NULL)
		{
			return;
		}
		foreach ($array as & $fieldset)
		{
			if ($fieldset->legend() == $legend)
			{
				$result = $fieldset;
				return;
			}
			$this->_search_fieldset($legend, $result, $fieldset->children());
		}
	}
    
}
