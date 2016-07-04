<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

View_Template::set_instance('frontend', new Template_Frontend('template/frontend'));

Route::set('site_announcements/home', Site::current_home_module() == 'site_announcements' ? '' : TRUE)
	->defaults(array(
		'directory'		=> 'template',
		'controller'	=> 'announcements',
		'action'		=> 'home'
	));

Route::set('site_jobs/home', Site::current_home_module() == 'site_jobs' ? '' : TRUE)
	->defaults(array(
		'directory'		=> 'template',
		'controller'	=> 'jobs',
		'action'		=> 'home'
	));

Route::set('site_products/home', Site::current_home_module() == 'site_products' ? '' : TRUE)
	->defaults(array(
		'directory'		=> 'template',
		'controller'	=> 'products',
		'action'		=> 'home'
	));

Route::set('site_products/frontend/products/contact', TRUE, array('id' => '[0-9]+'))
	->defaults(array(
		'directory'	 => 'template',
		'controller'	=> 'products',
		'action'		=> 'contact'
	));

Route::set('site_announcements/frontend/announcements/contact', TRUE, array('id' => '[0-9]+'))
	->defaults(array(
		'directory'	 => 'template',
		'controller'	=> 'announcements',
		'action'		=> 'contact'
	));

Route::set('site_catalog/frontend/company/contact', TRUE, array('id' => '[0-9]+'))
	->defaults(array(
		'directory'	 => 'template',
		'controller'	=> 'catalog',
		'action'		=> 'contact'
	));

Events::add_listener('settings/form_appearance_create', array('Events_Template_Settings', 'on_form_appearance_create'));
