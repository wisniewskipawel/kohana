<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Languages {
	
	public static function all()
	{
		return Kohana::$config->load('languages.available');
	}
	
	public static function refresh()
	{
		if (Cookie::get('language', NULL) === NULL)
		{
			$lang = Kohana::$config->load('languages.default');
			Cookie::set('language', $lang);
		}
		else
		{
			$lang = Cookie::get('language');
		}
		
		I18n::$lang = $lang;
	}
	
	public static function change($lang)
	{
		Cookie::set('language', $lang);
	}
	
	public static function set_default($lang, $section = 'frontend')
	{
		$config = Kohana::$config->load('modules');
		
		$config->set('site_languages', array(
			$section => array(
				'default' => $lang,
			),
		));
	}
	
	public static function upload(array $file)
	{
		$filename = $file['name'];
		upload::save($file, $filename, APPPATH . 'i18n');
	}
	
	public static function current($section = 'frontend')
	{
		$current = Kohana::$config->load('modules.site_languages.'.$section.'.default');
		
		if(!$current)
		{
			$current = Kohana::$config->load('languages.'.$section.'.default');
		}
		
		return $current;
	}
	
}
