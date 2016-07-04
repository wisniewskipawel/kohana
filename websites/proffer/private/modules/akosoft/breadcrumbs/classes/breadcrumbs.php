<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class breadcrumbs {

	protected static $_path = array();

	public static function add(array $path) 
	{
		self::$_path = $path;
	}

	public static function render($view = 'site') 
	{	
		$count = count(self::$_path);

		echo View::factory('breadcrumbs/' . $view)
				->set('path', self::$_path)
				->set('count', $count);
	}
	
	public static function get()
	{
		$b = array();
		foreach (self::$_path as $name => $url)
		{
			$b[$name] = URL::site($url);
		}
		return $b;
	}
	
	public static function not_empty()
	{
		return !empty(self::$_path);
	}
}
