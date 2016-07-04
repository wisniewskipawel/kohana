<?php defined('SYSPATH') or die('No direct script access.');

Route::set('sitemap/generate', 'sitemap-<module>-<offset>.xml(<gzip>)', array('module' => '[a-z_]++' ,'offset' => '[0-9]++', 'gzip' => '\.gz'))
	->defaults(array(
		'controller' => 'sitemap',
		'action'	=> 'generate',
	));
