<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Notifier {
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('notifier'),
				(array)Kohana::$config->load('modules.site_notifier.settings')
			);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}
	
}
