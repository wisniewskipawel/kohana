<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
payment::register_provider('transferuj');

Route::set('transferuj/return/success', 'transferuj/success')
	->defaults(array(
		'directory' => 'frontend',
		'controller' => 'transferuj',
		'action' => 'success',
	));

Route::set('transferuj/return/error', 'transferuj/error')
	->defaults(array(
		'directory' => 'frontend',
		'controller' => 'transferuj',
		'action' => 'error',
	));

Route::set('transferuj/bridge', 'transferuj/bridge')
	->defaults(array(
		'controller' => 'transferuj',
		'action' => 'bridge',
	));
