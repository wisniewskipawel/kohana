<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl 
* @copyright	Copyright (c) 2012, AkoSoft
*/
class Image_GD extends Kohana_Image_GD {
	
	public static function is_bundled()
	{
		if ( ! Image_GD::$_checked)
		{
			// Run the install check
			Image_GD::check();
		}
		
		foreach(Image_GD::$_available_functions as $is_available)
		{
			if(!$is_available)
				return FALSE;
		}
		
		return TRUE;
	}
	
}