<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Image_Imagick extends Kohana_Image_Imagick {
	
	public static function check()
	{
		if ( ! extension_loaded('imagick'))
		{
			throw new Kohana_Exception('Imagick is not installed, or the extension is not loaded');
		}
	
		$imagick = new Imagick();

		if(!method_exists($imagick, 'getImageAlphaChannel'))
		{
			throw new Exception('Imagick version required: >= 6.4.0');
		}

		return Image_Imagick::$_checked = TRUE;
	}
	
}
