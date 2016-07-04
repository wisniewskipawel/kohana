<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

payment::register_module('company_add');
payment::register_module('company_promote');

$module = Modules::instance()->register('site_catalog');

if ( ! $module->routes()) 
{
	Route::set('site_catalog/home', Site::current_home_module() == 'site_catalog' ? '' : TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'home'
			));
	
	Route::set('site_catalog/frontend/catalog/pre_add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'pre_add'
			));
	
	Route::set('site_catalog/frontend/catalog/add_to_closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'add_to_closet'
			));
	
	Route::set('site_catalog/frontend/catalog/closet/delete', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'closet_delete'
			));
	
	Route::set('site_catalog/profile/closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'closet'
			));
	
	Route::set('site_catalog/profile/catalog/renew', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'renew'
			));
	
	Route::set('site_catalog/frontend/catalog/send', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'send'
			));
	
	Route::set('site_catalog/frontend/catalog/print', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'print',
				'controller'	=> 'catalog',
				'action'		=> 'company'
			));
	
	Route::set('site_catalog/frontend/catalog/advanced_search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'advanced_search'
			));
	
	Route::set('site_catalog/profile/catalog/delete_image', TRUE, array('image_id' => '[0-9]+', 'company_id' => '[0-9]+'))
			->defaults(array(
				'directory' => 'profile',
				'controller' => 'catalog',
				'action' => 'delete_image'
			));
	
	Route::set('site_catalog/frontend/catalog/search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'search'
			));
	
	Route::set('site_catalog/frontend/catalog/add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'add'
			));
	
	Route::set('site_catalog/frontend/catalog/add_basic', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'add_basic'
			));
	
	Route::set('site_catalog/frontend/catalog/add_promoted', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'add_promoted'
			));
	
	Route::set('site_catalog/profile/catalog/my', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'my'
			));
	
	Route::set('site_catalog/profile/catalog/prolong_promote', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'prolong_promote'
			));
	
	Route::set('site_catalog/profile/catalog/delete', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'delete'
			));
	
	Route::set('site_catalog/frontend/catalog/show_category', TRUE, array('id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'category'
			));
	
	Route::set('site_catalog/frontend/catalog/show', TRUE, array('company_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'show_company'
			));
	
	Route::set('site_catalog/profile/catalog/edit_promoted', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'edit_promoted'
			));
	
	Route::set('site_catalog/profile/catalog/edit_basic', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'edit_basic'
			));
	
	Route::set('site_catalog/profile/catalog/delete', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'delete'
			));
	
	Route::set('site_catalog/profile/catalog/promote', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'catalog',
				'action'		=> 'promote'
			));
	
	Route::set('site_catalog/frontend/catalog/promoted', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'catalog',
				'action'		=> 'promoted'
			));
	
	Route::set('site_catalog/frontend/catalog/reviews/add', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend/catalog',
				'controller'	=> 'reviews',
				'action'		=> 'add',
			));
	
	if(catalog::is_subdomain_enabled())
	{
		Route::set('subdomain_error', 'errors/<action>')
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'errors',
				'subdomain'		=> Route::SUBDOMAIN_WILDCARD,
			));
		
		Route::set('site_catalog/company/show', '')
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'index',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/gallery', ___('site_catalog/company/gallery.subdomain'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'gallery',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/contact', ___('site_catalog/company/contact.subdomain'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'contact',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/reviews', ___('site_catalog/company/reviews.subdomain'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'reviews',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/reviews/add', ___('site_catalog/company/reviews/add.subdomain'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'review_add',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/offers', ___('site_catalog/company/offers.subdomain'))
			->defaults(array(
				'directory'		=> 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'offers',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));

		Route::set('site_catalog/company/announcements', ___('site_catalog/company/announcements.subdomain'))
			->defaults(array(
				'directory'		=> 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'announcements',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));
	}
	else
	{
		Route::set('site_catalog/company/show', ___('site_catalog/company/show.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'index'
			));

		Route::set('site_catalog/company/gallery', ___('site_catalog/company/gallery.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'gallery'
			));

		Route::set('site_catalog/company/contact', ___('site_catalog/company/contact.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'contact'
			));

		Route::set('site_catalog/company/reviews', ___('site_catalog/company/reviews.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'reviews'
			));

		Route::set('site_catalog/company/reviews/add', ___('site_catalog/company/reviews/add.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'review_add'
			));

		Route::set('site_catalog/company/offers', ___('site_catalog/company/offers.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'offers',
			));

		Route::set('site_catalog/company/announcements', ___('site_catalog/company/announcements.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'announcements',
			));
	}
	
	Route::set('site_catalog/frontend/catalog/offers', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'show_by_company',
			));
	
	Route::set('site_catalog/frontend/catalog/announcements', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend',
				'controller'	=> 'announcements',
				'action'		=> 'show_by_company',
			));
}

Route::set('catalog_admin_categories', 'admin/catalog/categories(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/catalog',
		'controller' => 'categories',
		'action'	 => 'index',
	));

Route::set('catalog_admin_companies', 'admin/catalog/companies(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/catalog',
		'controller' => 'companies',
		'action'	 => 'index',
	));

Route::set('catalog_admin_reviews', 'admin/catalog/reviews(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/catalog',
		'controller' => 'reviews',
		'action'	 => 'index',
	));

Cron::set('catalog_expiring', array('@daily', 'cron/catalog/expiring'));