<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
$module = Modules::instance()->register('site_documents');

if ( ! $module->routes()) 
{
	Route::set('site_documents/frontend/documents/show', TRUE, array('url' => '[a-zA-Z0-9\-_]+'))
		->defaults(array(
			'directory'         => 'frontend',
			'controller'        => 'documents',
			'action'            => 'show'
		));
}

Route::set('admin/documents/placements', 'admin/documents/placements(/<action>(/<id>))')
	->defaults(array(
		'directory'         => 'admin/documents',
		'controller'        => 'placements',
		'action'            => 'index'
	));
