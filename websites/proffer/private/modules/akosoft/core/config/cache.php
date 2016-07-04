<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array
(
	'file'    => array(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache',
		'default_expire'     => 3600,
		'ignore_on_delete'   => array(
			'.gitignore',
			'.git',
			'.svn'
		)
	),
	'config'    => array(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache',
		'default_expire'     => 3600,
		'ignore_on_delete'   => array(
			'.gitignore',
			'.git',
			'.svn'
		)
	),
);
