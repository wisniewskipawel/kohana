<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
$module = Modules::instance()->register('site_notifier');

if ( ! $module->routes()) 
{
	Route::set('site_notifier/home', Site::current_home_module() == 'site_notifier' ? '' : 'powiadamiacz')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'notifier',
				'action'		=> 'index'
			));
	
	Route::set('site_notifier/frontend/notifier/confirmation', 'powiadamiacz/potwierdz/<id>(/<token>)')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'notifier',
				'action'		=> 'confirm'
			));
	
	Route::set('site_notifier/frontend/notifier/unsubscribe', 'powiadamiacz/wypisz/<id>(/<token>)')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'notifier',
				'action'		=> 'unsubscribe'
			));
}

Cron::set('notifier_send', array('@daily', 'cron/notifier/send'));
