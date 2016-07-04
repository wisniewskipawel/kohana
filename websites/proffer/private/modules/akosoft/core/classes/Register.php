<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Register {
	
	private static $_values = array();
	
	public static function set($offset, $value) 
	{
		if (is_null($offset)) 
		{
			self::$_values[] = $value;
		} 
		else 
		{
			self::$_values[$offset] = $value;
		}
	}
	
	public static function exists($offset) 
	{
		return isset(self::$_values[$offset]);
	}
	
	public static function remove($offset) 
	{
		unset(self::$_values[$offset]);
	}
	
	public static function get($offset, $default = NULL) 
	{
		return isset(self::$_values[$offset]) ? self::$_values[$offset] : $default;
	}
}
