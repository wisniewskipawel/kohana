<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Upload extends Kohana_Upload {
	
	public static function max_filesize()
	{
		$max_upload = Num::bytes(ini_get('upload_max_filesize'));
		$max_post = Num::bytes(ini_get('post_max_size'));
		$memory_limit = Num::bytes(ini_get('memory_limit'));
		
		return min($max_upload, $max_post, $memory_limit);
	}
	
}
