<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
$module = Modules::instance()->register('site_products');

payment::register_module('product_add');
payment::register_module('product_promote');

if ( ! $module->routes())
{
	Route::set('site_products/home', Site::current_home_module() == 'site_products' ? '' : TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'home'
			));

	Route::set('site_products/frontend/products/add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'add'
			));

	Route::set('site_products/frontend/products/pre_add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'pre_add'
			));

	Route::set('site_products/frontend/products/search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'search'
			));

	Route::set('site_products/frontend/products/advanced_search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'advanced_search'
			));

	Route::set('site_products/frontend/products/category', TRUE, array('category_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'category'
			));

	Route::set('site_products/frontend/products/show', TRUE, array('product_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'show',
			));


	Route::set('site_products/frontend/products/promote', TRUE, array('product_id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'promote'
			));

	Route::set('site_products/frontend/products/index', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'index'
			));

	Route::set('site_products/frontend/products/promoted', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'promoted'
			));

	Route::set('site_products/frontend/products/show_by_user', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'show_by_user'
			));

	Route::set('site_products/frontend/products/show_by_company', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend',
				'controller'	=> 'products',
				'action'		=> 'show_by_company'
			));

	Route::set('site_products/frontend/products/send', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'send'
			));

	Route::set('site_products/frontend/products/print', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'print',
				'controller'	=> 'products',
				'action'		=> 'index'
			));

	Route::set('site_products/frontend/products/report', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'report'
			));

	Route::set('site_products/frontend/products/order', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend',
				'controller'	=> 'products',
				'action'		=> 'order'
			));
	
	// Profile

	Route::set('site_products/profile/products/my', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'my'
			));

	Route::set('site_products/profile/closet', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'closet'
			));

	Route::set('site_products/profile/products/delete_from_closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'delete_from_closet'
			));

	Route::set('site_products/profile/products/add_to_closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'add_to_closet'
			));

	Route::set('site_products/profile/products/edit', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'edit'
			));

	Route::set('site_products/profile/products/renew', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'renew'
			));

	Route::set('site_products/profile/products/delete', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'delete'
			));

	Route::set('site_products/profile/products/statistics', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'products',
				'action'		=> 'statistics'
			));

	Route::set('site_products/profile/products/delete_image', TRUE, array('image_id' => '[0-9]+', 'product_id' => '[0-9]+'))
			->defaults(array(
					'directory'  => 'profile',
					'controller' => 'products',
					'action'	 => 'delete_image',
			));

	Route::set('site_products/frontend/products/dig_up', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'products',
				'action'		=> 'dig_up'
			));

	Route::set('site_products/frontend/comments/add', TRUE)
		->defaults(array(
			'directory'		=> 'frontend/products',
			'controller'	=> 'comments',
			'action'		=> 'add',
		));

	Route::set('site_products/frontend/comments/vote', TRUE)
		->defaults(array(
			'directory'		=> 'frontend/products',
			'controller'	=> 'comments',
			'action'		=> 'vote',
		));

	Route::set('site_products/frontend/comments/report', TRUE)
		->defaults(array(
			'directory'		=> 'frontend/products',
			'controller'	=> 'comments',
			'action'		=> 'report',
		));

	Route::set('site_products/frontend/products/tag', TRUE)
		->defaults(array(
			'directory'		=> 'frontend',
			'controller'	=> 'products',
			'action'		=> 'tag',
		));

	if(Modules::enabled('site_catalog') AND catalog::is_subdomain_enabled())
	{
		Route::set('site_catalog/company/products', ___('site_catalog/company/products.subdomain'))
			->defaults(array(
				'directory'		=> 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'products',
				'subdomain' => Route::SUBDOMAIN_WILDCARD,
			));
	}
	else
	{
		Route::set('site_catalog/company/products', ___('site_catalog/company/products.site'))
			->defaults(array(
				'directory'	 => 'subdomain',
				'controller'	=> 'catalog',
				'action'		=> 'pages',
				'page'		=> 'products',
			));
	}
	
	Route::set('site_catalog/frontend/catalog/products', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'		=> 'frontend',
				'controller'	=> 'products',
				'action'		=> 'show_by_company',
			));
	
}

Route::set('admin_products_categories_actions', 'admin/products/categories(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/products',
		'controller' => 'categories',
		'action'	 => 'index',
	));


Route::set('admin_products_types_actions', 'admin/products/types(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/products',
		'controller' => 'types',
		'action'	 => 'index',
	));

Route::set('admin_products_availabilities_actions', 'admin/products/availabilities(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/products',
		'controller' => 'availabilities',
		'action'	 => 'index',
	));


Route::set('admin_products_settings_actions', 'admin/products/settings(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/products',
		'controller' => 'settings',
		'action'	 => 'index',
	));


Route::set('admin_products_settings_actions', 'admin/product/<controller>(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/product',
		'action'	 => 'index',
	));

Cron::set('products_expiring', array('@daily', 'cron/products/expiring'));
