<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Modules {
	
	protected $_routes_registered = array();
	protected $_data = array();
	protected $_config = array();
	
	protected $_disabled_modules = array();
	protected $_modules = array();
	
	protected static $_instance = NULL;
	
	const NOT_AVAILABLE = -1;
	const DISABLED = 0;
	const ENABLED = 1;
	
	/**
	 * @return self
	 */
	public static function instance()
	{
		if (self::$_instance === NULL)
		{
			self::$_instance = new self;
		}

		return self::$_instance;
	}
	
	private final function __construct()
	{
		
	}
	
	public function register($module, $config = NULL)
	{
		if($module instanceof Module_Future)
		{
			$module_name = $module->get_name();
		}
		else
		{
			$module_name = $module;
			$module = new Module($module_name, $config);
		}
		
		$module->on_initialize();
		
		return $this->_modules[$module_name] = $module;
	}
	
	public function get($module_name)
	{
		if ( ! isset($this->_modules[$module_name]))
		{
			throw new Exception("Module '$module_name' is not registered!");
		}
		
		return $this->_modules[$module_name];
	}
	
	public static function enabled($module_name) 
	{	
		if (!self::_is_enabled($module_name))
		{
			return FALSE;
		}
		
		if (Arr::get(Kohana::modules(), $module_name, NULL) === NULL)
		{
			return FALSE;
		}
		
		return TRUE;
	}
	
	public static function is_available_module($module_name)
	{
		$path = MODPATH.$module_name;
		
		return is_dir($path);
	}
	
	public function get_available_list()
	{
		return array_merge($this->_modules, $this->_disabled_modules);
	}
	
	public function home_modules()
	{
		$home_modules = array();
		
		foreach($this->_modules as $name => $module)
		{
			if($module->param('home_module'))
			{
				$home_modules[$name] = $module;
			}
		}
		
		return $home_modules;
	}
	
	public function current_module()
	{
		$request = Request::initial();
		
		if($request)
		{
			$route = $request->route();
			$route_name = $route ? Route::name($route) : NULL;

			$route_name_parts = explode('/', $route_name);
			
			foreach($this->_modules as $name => $module)
			{
				if(Arr::get($route_name_parts, 0) == $module->get_name())
				{
					return $module;
				}
			}
		}
		
		return FALSE;
	}
	
	public function is_current_module($module_name)
	{
		$module = $this->current_module();
		return $module AND $module->get_name() == $module_name;
	}
	
	public static function status($module_name)
	{
		if(!self::is_available_module($module_name))
			return self::NOT_AVAILABLE;
		
		return self::enabled($module_name) ? self::ENABLED : self::DISABLED;
	}
	
	protected static function _is_enabled($module_name)
	{
		$enabled = Kohana::$config->load('modules.' . $module_name .'.enabled');
		
		return $enabled !== FALSE;
	}
	
	public static function load()
	{
		$site_modules = self::load_modules(FALSE);
		$template_modules = self::load_templates(FALSE);
		
		Kohana::init_modules($site_modules);
		Kohana::init_modules($template_modules);
	}

	public static function load_modules($init = TRUE)
	{
		$modules = Kohana::$config->load('modules.list_modules');
		
		if(empty($modules))
		{
			return NULL;
		}
		
		$enabled_modules = array();

		foreach($modules as $module_name)
		{
			$module_path = 'akosoft'.DIRECTORY_SEPARATOR.$module_name;
			
			if(self::is_available_module($module_path))
			{
				if(self::_is_enabled($module_name))
				{
					$enabled_modules[$module_name] = MODPATH.$module_path.DIRECTORY_SEPARATOR;
				}
				else
				{
					Modules::instance()->_disabled_modules[$module_name] = new Module_Disabled($module_name);
				}
			}
		}
		
		if(empty($enabled_modules))
		{
			return NULL;
		}
		
		Kohana::add_modules('site_modules', $enabled_modules, $init);
		
		$enabled_modules = Kohana::modules();
		
		Events::fire('site/modules_loaded');
		
		return $enabled_modules;
	}
	
	public static function load_templates($init = TRUE)
	{
		$template_modules = array();

		foreach(Kohana::$config->load('templates.enabled') as $templ_place => $template)
		{
			$template_modules[$template] = AkoSoft::$templates_path.$template.DIRECTORY_SEPARATOR;
		}
		
		Kohana::add_modules('templates', $template_modules, $init);
		
		return $template_modules;
	}
	
	public static function load_template($template_name) 
	{
		return Kohana::modules(array(
			$template_name => AkoSoft::$templates_path.$template_name,
		));
	}
	
	public function registered_modules()
	{
		return $this->_modules;
	}
	
	public function enabled_modules()
	{
		$modules = $this->registered_modules();
		$enabled_modules = array();
		
		foreach($modules as $module_name => $module)
		{
			if(Modules::enabled($module_name))
			{
				$enabled_modules[$module_name] = $module;
			}
		}
		
		return $enabled_modules;
	}
	
}
