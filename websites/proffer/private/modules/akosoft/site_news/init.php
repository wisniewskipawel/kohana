<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
$module = Modules::instance()->register('site_news');

if ( ! $module->routes()) 
{
	Route::set('site_news/frontend/news/show', TRUE, array('title' => '[a-zA-Z0-9\-_]+', 'id' => '[0-9]+'))
		->defaults(array(
			'directory'         => 'frontend',
			'controller'        => 'news',
			'action'            => 'show'
		));

	Route::set('site_news/frontend/news/index', TRUE)
		->defaults(array(
			'directory'     => 'frontend',
			'controller'    => 'news',
			'action'        => 'index'
		));
}