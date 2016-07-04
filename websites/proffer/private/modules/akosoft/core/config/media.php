<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'css'	   => array(
		'disk_path'		=> (DOCROOT . 'media' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR),
		'web_path'		=> 'media/css/',
		'cache_expire_after'	=> (Date::WEEK * 2),
		'minify'			=> Kohana::$environment !== Kohana::DEVELOPMENT,
		'combine'			=> Kohana::$environment !== Kohana::DEVELOPMENT,
	),
	'js'	=> array(
		'disk_path'		=> (DOCROOT . 'media' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR),
		'web_path'		=> 'media/js/',
		'cache_expire_after'	=> (Date::WEEK * 2),
		'minify'			=> Kohana::$environment !== Kohana::DEVELOPMENT,
	),
	'no_expires_headers' => Kohana::$environment == Kohana::DEVELOPMENT,
);
