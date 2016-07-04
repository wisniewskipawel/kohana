<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Widget_Box {
	
	public static function factory($name, $params = NULL)
	{
		// Set class name
		$widget = 'Widget_'.ucfirst(str_replace('/', '_', $name));
		
		if(class_exists($widget))
		{
			return new $widget($name, $params);
		}
		else
		{
			return new self($name, $params);
		}
	}
	
	protected $_view_file = NULL;
	
	protected $_params = NULL;
	
	public function __construct($view_file, $params = NULL)
	{
		$this->_view_file = $view_file;
		$this->_params = $params;
	}
	
	public function set_params($params)
	{
		$this->_params = $params;
		
		return $this;
	}
	
	public function set($name, $value)
	{
		$this->_params[$name] = $value;
		
		return $this;
	}
	
	public function get($name, $default = NULL)
	{
		return Arr::get($this->_params, $name, $default);
	}
	
	public function render($view_file = NULL)
	{
		if(!$view_file)
		{
			$view_file = 'widget/'.$this->_view_file;
		}
		
		return View::factory($view_file, $this->_params)
			->render();
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
		}
		
		return '';
	}
	
}
