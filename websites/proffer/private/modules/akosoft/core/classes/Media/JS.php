<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Media_JS {

	protected static $_files = array();

	public static function add($file_path, $options = NULL)
	{
		$asset = new Asset_JS($file_path, $options);
		
		if(!isset(self::$_files[$file_path]))
		{
			self::$_files[$file_path] = $asset;
		}
	}

	public static function render() 
	{
		$scripts = '';
		
		foreach (self::$_files as $file_path => $asset)
		{
			$asset->compile();
			$scripts .= HTML::script($asset->get_web_path());
		}
		
		return $scripts;
	}
	
}
