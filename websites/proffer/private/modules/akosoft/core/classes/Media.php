<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Media {
	
	public static function css($uri = NULL, $directory = NULL, $options = array())
	{
		if($uri !== NULL)
		{
			if($directory)
			{
				$directory = rtrim($directory, '/').'/';
			}
			else
			{
				$directory = 'css/';
			}
			
			Media_CSS::add($directory.$uri, $options);
		}
		else
		{
			return Media_CSS::render();
		}
	}
	
	public static function js($uri = NULL, $directory = NULL, $options = array())
	{
		if($uri !== NULL)
		{
			if($directory)
			{
				$directory = rtrim($directory, '/').'/';
			}
			else
			{
				$directory = 'js/';
			}
			
			Media_JS::add($directory.$uri, $options);
		}
		else
		{
			return Media_JS::render();
		}
	}
	
	public static function find_file($directory, $filename)
	{
		$directory = trim($directory, '/').'/';
		
		if(file_exists(DOCROOT.'media/'.$directory.$filename))
		{
			return DOCROOT.'media/'.$directory.$filename;
		}
		
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$file = str_replace('.'.$ext, '', $filename);
		
		$search_paths = array('media/'.$directory);
		
		$template_style = Kohana::$config->load('global.site.template_style');
		
		if($template_style && $template_style != 'custom')
		{
			$search_paths[] = 'media/'.$template_style.'/'.$directory;
		}
		
		$search_paths[] = 'media/default/'.$directory;
		
		foreach($search_paths as $path)
		{
			$file_path = Kohana::find_file($path, $file, $ext);
			
			if($file_path)
				return $file_path;
		}
		
		return NULL;
	}
	
	public static function clear_compiled()
	{
		return Files::delete_directory(DOCROOT.'media/compiled/', TRUE);
	}
	
}