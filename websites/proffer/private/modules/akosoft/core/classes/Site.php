<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Site {
	
	protected static $_config = NULL;

	public static function config($path = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('site'), 
				(array)Kohana::$config->load('global.site')
			);
		}
		
		if($path === NULL)
		{
			return self::$_config;
		}
		
		return Arr::path(self::$_config, $path, $default);
	}

	public static function subdomain_modules()
	{
		$modules = array();
		
		foreach(Modules::instance()->enabled_modules() as $name => $module)
		{
			if($module->param('subdomain_module'))
			{
				$modules[$name] = $module->get_title();
			}
		}
		
		return $modules;
	}
	
	public static function current_subdomain_module()
	{
		return self::config('subdomain_module');
	}

	public static function home_modules()
	{
		$home_modules = array();
		
		foreach(Modules::instance()->home_modules() as $module_name => $module)
		{
			$home_modules[$module_name] = $module->get_title();
		}
		
		return $home_modules;
	}
	
	public static function current_home_module()
	{
		return self::config('home_module');
	}
	
}
