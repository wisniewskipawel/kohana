<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Collection implements ArrayAccess, IteratorAggregate {

	/**
	 * Drivers container
	 *
	 * @var array Array of drivers
	 */
	protected $_elements = array();

	protected $_options = array(
		'decorate' => TRUE,
		'form' => NULL,
		'parent_collection' => NULL,
		'name' => NULL,
		'get_values_path' => NULL,
		'set_values_path' => NULL,
	);

	public function __construct(Bform_Core_Form $form = NULL, $name, $options = array())
	{
		if(!is_array($options))
		{
			$options = array();
		}
		
		$options['name'] = $name;
		
		$this->options($options);
		$this->_options['form'] = $form;
	}

	public function execute_filters()
	{
		foreach($this->get_all() as $element)
		{
			$element->execute_filters();
		}
	}

	public function execute_validators()
	{
		$errors = array();

		foreach ($this->get_all() as $element)
		{
			$errors = array_merge($errors, $element->execute_validators());
		}

		return $errors;
	}

	public function data($key)
	{
		return Arr::get(array(
			'name' => $this->option('name'),
		), $key);
	}

	public function options($options = NULL)
	{
		if($options)
		{
			$this->_options = array_merge($this->_options, $options);
		}

		return $this->_options;
	}

	public function option($key = NULL, $default = NULL)
	{
		return Arr::path($this->_options, $key, $default);
	}
	
	public function set_option($key, $value)
	{
		$this->_options[$key] = $value;
		return $this;
	}

	public function set_values($values, $parent_collection_name = NULL)
	{
		if(empty($values))
		{
			return;
		}
		
		foreach($this->get_all() as $element)
		{
			//set value for driver
			$element->set_values($values);
		}
	}
	
	public function get_relative_path($type)
	{
		if($type == 'get')
		{
			return $this->option('get_values_path') !== NULL ? $this->option('get_values_path') : $this->option('name');
		}
		elseif($type == 'set')
		{
			return $this->option('set_values_path') !== NULL ? $this->option('set_values_path') : $this->option('name');
		}
	}
	
	public function get_values($not_empty = FALSE, $with_form_id = FALSE)
	{
		$_elements = $this->get_all();

		$values = array();

		foreach ($_elements as $e)
		{
			if($e instanceof Bform_Driver_Collection)
			{
				$collection_values = $e->get_values($not_empty, $with_form_id);
				
				if(!Valid::not_empty($collection_values) AND $not_empty === TRUE)
					continue;
				
				$relative_path = $e->get_relative_path('get');
					
				if($relative_path === '')
				{
					$values = array_merge_recursive($values, $collection_values);
				}
				else
				{
					$tmp_array = array();
					Arr::set_path($tmp_array, $relative_path, $collection_values);
					
					$values = Arr::merge($values, $tmp_array);
				}
				
				continue;
			}

			if($with_form_id === FALSE AND $e instanceof Bform_Driver_Input_hidden AND $e->data('name') == 'form_id')
			{
				continue;
			}

			$values = $e->on_get_values($values, $not_empty);
		}

		return $values;
	}

	/**
	 *
	 * @param bool $not_empty
	 * @return array
	 */
	public function get_files($not_empty = TRUE) 
	{
		$drivers = $this->get_all();

		$files = array();

		foreach ($drivers as $d)
		{
			if($d instanceof Bform_Core_Driver_Collection)
			{
				$collection_files = $d->get_files($not_empty);
				
				if($collection_files)
				{
					$files = array_merge($files, $collection_files);
				}
			}
			elseif ($d instanceof Bform_Driver_Input_file)
			{
				$value = $d->get_value();
				
				if(Upload::valid($value))
				{
					if ($not_empty)
					{
						if(Upload::not_empty($value))
						{
							$files[$d->data('name')] = $value;
						}
					} 
					else
					{
						$files[$d->data('name')] = $value;
					}
				}
			}
		}

		return $files;
	}
	
	public function add_driver($name, $driver)
	{
		$path = $driver->data('path');
		$abs_path = $this->get_path();
		
		if($path == $name AND $abs_path)
		{
			$path = $this->get_path().'.'.$path;
		}

		$driver->data('path', $path);
		$driver->data('collection', $this);
		
		if(method_exists($driver, 'on_add_driver'))
		{
			$driver->on_add_driver();
		}
		
		$form_values = $this->form()->form_data();
		
		if($form_values)
		{
			$driver->set_values($form_values);
		}

		return $this->_elements[$name] = $driver;
	}

	/**
	 * Add validator to the driver
	 *
	 * @param type $driver_name Name of the driver - array key in Bform_Driver_Collection::$_elements
	 * @param type $validator_class_str Validator class name
	 * @param array $options Params passed into Validator Class
	 * @return Bform_Form
	 */
	public function add_validator($driver_name, $validator_class_str, array $options = array())
	{
		$driver = Arr::path($this->get_all(), $driver_name);

		if ($driver === NULL)
		{
			throw new Bform_Exception("Driver \"$driver_name\" do not exists!");
		}

		$driver->add_validator($validator_class_str, $options);

		return $this;
	}
	
	public function add_filter($driver_name, $class_str, array $options = array())
	{
		$driver = Arr::get($this->get_all(), $driver_name);

		if ($driver === NULL)
		{
			throw new Bform_Exception("Driver \"$driver_name\" do not exists!");
		}

		$driver->add_filter($class_str, $options);

		return $this;
	}
	
	public function add_collection($name, $options = array())
	{
		$options['parent_collection'] = $this;
		
		return $this->add_driver($name, new Bform_Driver_Collection($this->form(), $name, $options));
	}
	
	public function add_fieldset($name, $label, $options = array())
	{
		$options['parent_collection'] = $this;
		$options['label'] = $label;
		
		return $this->add_driver($name, new Bform_Driver_Fieldset($this->form(), $name, $options));
	}

	public function __set($name, $value)
	{
		$this->add_driver($name, $value);
	}

	public function __get($name)
	{
		if (isset($this->_elements[$name]))
		{
			return $this->_elements[$name];
		}
		else
		{
			return NULL;
		}
	}

	public function __call($function, $values) 
	{
		if (substr($function, 0, 4) == 'add_')
		{
			$type = substr($function, 4);
			$name = $values[0];

			$driver_cls_name = 'Bform_Driver_' . ucfirst($type);

			if ( ! class_exists($driver_cls_name)) 
			{
				throw new Bform_Exception("Class $driver_cls_name doesn't exists!");
			}

			array_unshift($values, $this->form());
			
			$reflect  = new ReflectionClass($driver_cls_name);
			$element = $reflect->newInstanceArgs($values);

			if ($this->has($element->data('name'))) 
			{
				throw new Bform_Exception("Element \"{$element->data('name')}\" already exists!");
			}

			$this->add_driver($element->data('name'), $element);
		} 
		else
		{
			if ( ! method_exists($this, $function)) {
				throw new Bform_Exception("Method '$function' doesnt exists!");
			}
		}

		return $this;
	}

	public function get_all()
	{
		return $this->_elements;
	}

	public function has($field, $check_child_collections = FALSE)
	{
		$result = isset($this->_elements[$field]);
		
		if(!$result AND $check_child_collections)
		{
			foreach($this->get_all() as $elements)
			{
				if($elements instanceof Bform_Core_Driver_Collection)
				{
					if($elements->has($field, TRUE))
					{
						return TRUE;
					}
				}
			}
		}
		
		return $result;
	}

	public function get($name)
	{
		return isset($this->_elements[$name]) ? $this->_elements[$name] : NULL;
	}

	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->_elements[] = $value;
		}
		else
		{
			$this->_elements[$offset] = $value;
		}
	}
	public function offsetExists($offset)
	{
		return isset($this->_elements[$offset]);
	}

	public function offsetUnset($offset)
	{
		unset($this->_elements[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->_elements[$offset]) ? $this->_elements[$offset] : NULL;
	}

	public function getIterator()
	{
		return new ArrayIterator($this);
	}
	
	public function render($decorate = NULL)
	{
		if($decorate !== NULL)
		{
			$this->set_option('decorate', $decorate);
		}
		
		return View::factory('bform/'.$this->form()->template().'/forms/render_collection')
			->set('collection', $this)
			->set('form', $this->form())
			->set('options', $this->options());
	}
	
	public function get_path()
	{
		$path = $this->get_relative_path('set');
		
		if($this->option('parent_collection'))
		{
			$parent_path = $this->option('parent_collection')->get_path();
			
			if($parent_path)
			{
				$path = $parent_path.'.'.$path;
			}
		}
		
		return trim($path, '.');
	}
	
	public function form()
	{
		return $this->option('form');
	}
	
	public function __toString()
	{
		try
		{
			return (string)$this->render();
		}
		catch(Exception $ex)
		{
			Kohana_Exception::log($ex, Log::ERROR);
			
			return Kohana_Exception::text($ex);
		}
	}
	
}
