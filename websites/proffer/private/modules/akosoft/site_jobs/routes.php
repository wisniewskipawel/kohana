<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

Route::set('site_jobs/home', Site::current_home_module() == 'site_jobs' ? '' : TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'home'
		));

Route::set('site_jobs/frontend/jobs/add', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'add'
		));

Route::set('site_jobs/frontend/jobs/search', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'search'
		));

Route::set('site_jobs/frontend/jobs/advanced_search', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'advanced_search'
		));

Route::set('site_jobs/frontend/jobs/category', TRUE, array('category_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'category'
		));

Route::set('site_jobs/frontend/jobs/show', TRUE, array('job_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'show',
		));

Route::set('site_jobs/frontend/jobs/index', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'index'
		));

Route::set('site_jobs/frontend/jobs/promoted', TRUE)
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'promoted'
		));

Route::set('site_jobs/frontend/jobs/show_by_user', TRUE, array('user_id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'show_by_user',
		));

Route::set('site_jobs/frontend/jobs/send', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'send'
		));

Route::set('site_jobs/frontend/jobs/print', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'print',
			'controller'	=> 'jobs',
			'action'		=> 'index'
		));

Route::set('site_jobs/frontend/jobs/contact', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'contact'
		));

Route::set('site_jobs/frontend/jobs/report', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'frontend',
			'controller'	=> 'jobs',
			'action'		=> 'report'
		));

// Profile

Route::set('site_jobs/profile/jobs/my', TRUE)
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'my'
		));

Route::set('site_jobs/profile/jobs/promote', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'promote'
		));

Route::set('site_jobs/profile/jobs/edit', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'edit'
		));

Route::set('site_jobs/profile/jobs/renew', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'renew'
		));

Route::set('site_jobs/profile/jobs/delete', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'delete'
		));

Route::set('site_jobs/profile/jobs/statistics', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile',
			'controller'	=> 'jobs',
			'action'		=> 'statistics'
		));

// Closet

Route::set('site_jobs/profile/closet', TRUE)
		->defaults(array(
			'directory'	 => 'profile/jobs',
			'controller'	=> 'closet',
			'action'		=> 'index'
		));

Route::set('site_jobs/profile/closet/delete', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile/jobs',
			'controller'	=> 'closet',
			'action'		=> 'delete'
		));

Route::set('site_jobs/profile/closet/add', TRUE, array('id' => '[0-9]+'))
		->defaults(array(
			'directory'	 => 'profile/jobs',
			'controller'	=> 'closet',
			'action'		=> 'add'
		));

if(Modules::enabled('site_notifier'))
{
	Route::set('site_notifier/notifier/jobs', TRUE)
		->defaults(array(
			'directory'		=> 'frontend/jobs',
			'controller'	=> 'notifier',
			'action'		=> 'index',
		));
}

// comments

Route::set('site_jobs/frontend/comments/add', TRUE)
	->defaults(array(
		'directory'		=> 'frontend/jobs',
		'controller'	=> 'comments',
		'action'		=> 'add',
	));

// replies

Route::set('site_jobs/frontend/replies/add', TRUE)
	->defaults(array(
		'directory'		=> 'frontend/jobs',
		'controller'	=> 'replies',
		'action'		=> 'add',
	));

// ADMIN

Route::set('admin/jobs', 'admin/job/<controller>(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/job',
		'action'	 => 'index',
	));
