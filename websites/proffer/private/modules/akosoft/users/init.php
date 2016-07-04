<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

payment::register_module('user');

$module = Modules::instance()->register('users');

if ( ! $module->routes()) 
{
	Route::set('bauth/frontend/auth/login', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'login',
			'secure' => TRUE,
		));
	
	Route::set('bauth/frontend/auth/register', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'register',
			'secure' => TRUE,
		));
	
	Route::set('bauth/frontend/auth/logout', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'logout',
			'secure' => TRUE,
		));
	
	Route::set('bauth/frontend/auth/new_password', TRUE, array('hash' => '[a-zA-Z0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'new_password',
			'secure' => TRUE,
		));
	
	Route::set('bauth/frontend/auth/activate', TRUE, array('hash' => '[a-zA-Z0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'activate'
		));
	
	Route::set('bauth/frontend/auth/lost_password', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'auth',
			'action'		=> 'lost_password',
			'secure' => TRUE,
		));

	Route::set('bauth/frontend/auth/send_activation_link', TRUE)
		->defaults(array(
			'directory' => 'frontend',
			'controller' => 'auth',
			'action' => 'send_activation_link',
			'secure' => TRUE,
		));
	
	// Facebook
	
	Route::set('bauth/frontend/facebook/login', TRUE)
		->defaults(array(
			'directory'	 => 'frontend/bauth',
			'controller'	=> 'facebook',
			'action'		=> 'login',
			'secure' => TRUE,
		));
	
	Route::set('bauth/frontend/facebook/register', TRUE)
		->defaults(array(
			'directory'	 => 'frontend/bauth',
			'controller'	=> 'facebook',
			'action'		=> 'register',
			'secure' => TRUE,
		));
	
	//profile
	
	Route::set('site_profile/profile/settings/change', TRUE)
		->defaults(array(
			'directory'     => 'profile',
			'controller'    => 'settings',
			'action'        => 'change',
			'secure' => TRUE,
		));

	Route::set('site_profile/frontend/profile/index', TRUE)
		->defaults(array(
			'directory'     => 'profile',
			'controller'    => 'index',
			'action'        => 'index'
		));
	
	//admin
	
	Route::set('admin/login', 'admin/auth/login')
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'auth',
			'action'	 => 'login',
			'secure' => TRUE,
		));

	Route::set('admin/settings/change_password', 'admin/settings/change_password')
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'settings',
			'action'	 => 'change_password',
			'secure' => TRUE,
		));
	
	Route::set('admin/email/blacklist', 'admin/email/blacklist(/<action>(/<id>))', array('id' => '[a-zA-Z0-9-_]+'))
		->defaults(array(
			'directory'  => 'admin/email',
			'controller' => 'blacklist',
			'action'	 => 'index',
		));

}
