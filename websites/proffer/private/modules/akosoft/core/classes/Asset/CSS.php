<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Asset_CSS extends Asset {
	
	protected function _recompile($dest_file_path)
	{
		$contents = $this->get_contents();
		
		if(Kohana::$config->load('media.css.minify') AND Arr::get($this->_options, 'minify', FALSE))
		{
			require_once Kohana::find_file('vendor', 'minify/Minify/Loader');
			Minify_Loader::register();
			
			$contents = Minify_CSS::minify($contents);
		}
		
		return $contents;
	}
	
}
