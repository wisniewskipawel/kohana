<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Media_CSS {
	
	protected static $_files = array();

	public static function add($file_path, $options = NULL)
	{
		$asset = new Asset_CSS($file_path, $options);
		
		if(!empty($options['combine']) AND Kohana::$config->load('media.css.combine') AND !$asset->is_user_modified())
		{
			if(!isset(self::$_files['combined']))
			{
				self::$_files['combined'] = new Asset_Collection('css/combined');
			}
			
			self::$_files['combined']->add($asset);
		}
		elseif(!isset(self::$_files[$file_path]))
		{
			self::$_files[$file_path] = $asset;
		}
	}

	public static function render() 
	{
		$styles = '';
		
		foreach (self::$_files as $asset)
		{
			$asset->compile();
			
			$styles .= HTML::style($asset->get_web_path());
		}
		
		return $styles;
	}
	
	public static function file_contents($css_files)
	{
		$minify =  Kohana::$config->load('media.css.minify');
		
		if($minify)
		{
			require_once Kohana::find_file('vendor', 'minify/Minify/Loader');
			Minify_Loader::register();
		}
		
		$time_modified = 0;
		
		foreach($css_files as &$css)
		{
			if ( ! file_exists($css))
			{
				return FALSE;
			}
			
			$filemtime = filemtime($css);
			
			if($filemtime > $time_modified)
			{
				$time_modified = $filemtime;
			}
			
			$css = file_get_contents($css);

			if($minify)
			{
				$css = Minify_CSS::minify($css);
			}
		}
		
		$content = implode("\n", $css_files);
		
		$time_modified = gmdate("D, d M Y H:i:s", $time_modified);
		
		return array($content, $time_modified);
	}
}
