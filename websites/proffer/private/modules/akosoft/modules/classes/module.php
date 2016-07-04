<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Module extends Module_Base {
	
	protected $_is_current_module = NULL;
	
	public function get_namespace()
	{
		return $this->config('namespace');
	}
	
	public function version()
	{
		return $this->config('version');
	}
	
	public function admin_name()
	{
		return $this->get_title();
	}
	
	public function get_title()
	{
		return $this->config('title');
	}
	
	public function description()
	{
		return $this->config('description');
	}
	
	public function is_system_module()
	{
		return $this->config('is_system_module');
	}
	
	public function is_home_module()
	{
		return $this->config('is_home_module');
	}
	
	public function is_current_module()
	{
		if($this->_is_current_module !== NULL)
		{
			return $this->_is_current_module;
		}
		
		$this->_is_current_module = FALSE;
		$request = Request::initial();
		
		if($request)
		{
			$route = $request->route();
			$route_name = $route ? Route::name($route) : NULL;

			$route_name_parts = explode('/', $route_name);

			$this->_is_current_module = Arr::get($route_name_parts, 0) == $this->get_name();
		}
		
		return $this->_is_current_module;
	}
	
	public function param($key)
	{
		return $this->config($key);
	}
	
	public function config($key, $default = NULL)
	{
		return Arr::path($this->_config, $key, $default);
	}
	
	public function as_array()
	{
		return $this->_config;
	}
	
	public function can_disable()
	{
		return $this->config('can_disable', FALSE);
	}
	
}
