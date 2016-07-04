<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Module_Future extends Module {
	
	protected static $_instance = NULL;

	protected $_name = '';
	protected $_path = '';
	protected $_config = array();
	protected $_routes = FALSE;
	
	public static function instance($module_path = NULL)
	{
		if(!static::$_instance)
		{
			if(!$module_path)
			{
				throw new InvalidArgumentException('No required module path argument!');
			}
			
			static::$_instance = new static($module_path);
		}
		
		return static::$_instance;
	}

	public function __construct($module_path = NULL)
	{
		$this->_path = rtrim($module_path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
		$this->load_config();
	}
	
	public function on_initialize()
	{
		
	}
	
	public function load_config()
	{
		$config_file = $this->get_path().'config.php';
		
		if(file_exists($config_file))
		{
			$this->_config = include $config_file;
		}
	}
	
	public function register_routes()
	{
		$routes_file = $this->get_path().'routes.php';
		
		if(file_exists($routes_file))
		{
			$routes = include_once $routes_file;

			foreach($routes as $route_name => $route_params)
			{
				$route_name = $this->get_slug().'/'.$route_name;
				$route_params['defaults']['namespace'] = $this->get_namespace().'Controllers\\';
				
				if($route_name == $this->get_slug().'/'.'home' AND !isset($route_params['path']) AND $this->is_home_module())
				{
					$route_params['path'] = Site::current_home_module() == $this->get_name() ? '' : TRUE;
				}

				Route::set($route_name, Arr::get($route_params, 'path', TRUE), Arr::get($route_params, 'requirements'))
					->defaults(Arr::get($route_params, 'defaults'));
			}
		}
	}
	
	public function get_slug()
	{
		return $this->config('name');
	}
	
	public function get_name()
	{
		return $this->get_slug();
	}
	
	public function get_path()
	{
		return $this->_path;
	}
	
	public function get_title()
	{
		return $this->config('title');
	}
	
	public function get_description()
	{
		return $this->config('description');
	}
	
	public function get_version()
	{
		return $this->config('version');
	}
	
	public function get_namespace()
	{
		return $this->config('namespace');
	}
	
	public function is_installed()
	{
		return TRUE;
	}
	
	public function is_enabled()
	{
		return Kohana::$config->load('modules.' . $this->get_name() .'.enabled') !== FALSE;
	}
	
	public function is_system_module()
	{
		return $this->config('is_system_module');
	}
	
	public function is_home_module()
	{
		return $this->config('home_module');
	}
	
	public function is_current_module()
	{
		if(!Request::initial())
		{
			return FALSE;
		}
		
		$route = Request::initial()->route();
		$route_name = $route ? Route::name($route) : NULL;
		
		$route_name_parts = explode('/', $route_name);
		
		return Arr::get($route_name_parts, 0) == $this->get_name();
	}
	
	public function param($key)
	{
		return $this->config($key);
	}
	
	public function config($key, $default = NULL)
	{
		return Arr::get($this->_config, $key, $default);
	}
	
	public function get_config()
	{
		return $this->_config;
	}
	
}
