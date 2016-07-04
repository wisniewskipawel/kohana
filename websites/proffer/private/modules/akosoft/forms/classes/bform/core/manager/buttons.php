<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Manager_Buttons {

	protected $_started = FALSE;
	protected $_form = NULL;
	protected $_layout = '';
	protected $_buttons = array();

	public function __construct(Bform_Form $form)
	{
		$this->layout = Kohana::$config->load('bform.drivers.bform_driver_button.views.main.layout');

		if ($this->layout === NULL) {
			throw new Bform_Exception('Config error! Layout not found!');
		}
		$this->_form = $form;
	}

	public function layout($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_layout;
		}
		$this->_layout = $value;
		return $this;
	}

	public function buttons()
	{
		return $this->_buttons;
	}

	public function started($val = NULL) 
	{
		if ($val === NULL) 
		{
			return $this->_started;
		}
		
		if ( !is_bool($val)) 
		{
			throw new Bform_Exception('Check api!');
		}
		$this->_started = $val;
	}

	public function add_button(array $values) 
	{
		$type = $values[0];
		$value = $values[1];
		if (isset($values[2])) 
		{
			$info = $values[2];
		} 
		else
		{
			$info = array();
		}

		$button = new Bform_Driver_Button($this->_form, $type, $value, $info);
		$name = $button->data('name');

		if (array_key_exists($name, $this->_buttons)) 
		{
			throw new Bform_Exception("Button named ':name' already exists!", array(':name' => $name));
		}

		$this->_buttons[$name] = $button;
	}

	public function __toString() 
	{
		return $this->render();
	}

	public function render() 
	{
		try
		{
			return View::factory($this->_layout)->set('buttons', $this->_buttons)->render();
		} 
		catch (Exception $e) 
		{
			Kohana_Exception::handler($e);
		}
	}

}
