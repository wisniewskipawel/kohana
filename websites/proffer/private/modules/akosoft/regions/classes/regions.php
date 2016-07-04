<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Regions {
	
	const ALL_PROVINCES = 100;
	
	public static $type = 'default';
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Kohana::$config->load('regions.'.self::$type);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}

	public static function provinces()
	{
		return self::config('provinces');
	}
	
	public static function province($province_id)
	{
		return Arr::get(self::provinces(), $province_id);
	}

	public static function counties($province = NULL)
	{
		$counties = self::config('counties');
		
		return $province === TRUE ? Arr::flatten($counties, TRUE) : Arr::get($counties, $province);
	}
	
	public static function county($county_id, $province = TRUE)
	{
		//get counties by province id or TRUE for counies from all provinces
		$counites = self::counties($province);
		
		if(!empty($counites) AND is_array($counites))
		{
			return Arr::get($counites, $county_id);
		}
		
		return NULL;
	}
	
}