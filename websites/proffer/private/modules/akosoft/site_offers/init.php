<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
payment::register_module('offer_promote');
payment::register_module('offer_add');

$module = Modules::instance()->register('site_offers');

if ( ! $module->routes())
{
	Route::set('site_offers/home', Site::current_home_module() == 'site_offers' ? '' : TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'home'
			));

	Route::set('site_offers/profile/offers/promo_packets', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'promo_packets'
			));
	
	Route::set('site_offers/frontend/offers/add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'add'
			));

	Route::set('site_offers/frontend/offers/age_confirm', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'age_confirm'
			));

	Route::set('site_offers/frontend/offers/pre_add', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'pre_add'
			));

	Route::set('site_offers/frontend/offers/send_coupon', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'send_coupon'
			));

	Route::set('site_offers/profile/offers/coupons', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'coupons'
			));

	Route::set('site_offers/frontend/offers/contact', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'contact'
			));

	Route::set('site_offers/profile/offers/my', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'my'
			));

	Route::set('site_offers/profile/closet', TRUE)
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'closet'
			));

	Route::set('site_offers/profile/offers/delete_from_closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'delete_from_closet'
			));

	Route::set('site_offers/frontend/offers/search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'search'
			));

	Route::set('site_offers/frontend/offers/advanced_search', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'advanced_search'
			));

	Route::set('site_offers/frontend/offers/category', TRUE, array('category_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'category'
			));

	Route::set('site_offers/frontend/offers/show', TRUE, array('offer_id' => '[0-9]+', 'title' => '[a-zA-Z0-9\-_\/]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'show'
			));


	Route::set('site_offers/frontend/offers/promote', TRUE, array('offer_id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'promote'
			));

	Route::set('site_offers/frontend/offers/index', TRUE)
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'index'
			));

	Route::set('site_offers/frontend/offers/province', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'province'
			));

	Route::set('site_offers/profile/offers/add_to_closet', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'add_to_closet'
			));

	Route::set('site_offers/frontend/offers/send', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'send'
			));

	Route::set('site_offers/frontend/offers/show_by_user', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'show_by_user'
			));

	Route::set('site_offers/frontend/offers/show_by_company', TRUE, array('company_id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'show_by_company'
			));

	Route::set('site_offers/profile/offers/edit', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'edit'
			));

	Route::set('site_offers/profile/offers/renew', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'renew'
			));

	Route::set('site_offers/profile/offers/delete', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'delete'
			));

	Route::set('site_offers/profile/offers/statistics', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'profile',
				'controller'	=> 'offers',
				'action'		=> 'statistics'
			));

	Route::set('site_offers/frontend/offers/report', TRUE, array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'offers',
				'action'		=> 'report'
			));

	Route::set('site_offers/profile/offers/delete_image', TRUE, array('image_id' => '[0-9]+', 'offer_id' => '[0-9]+'))
			->defaults(array(
					'directory'  => 'profile',
					'controller' => 'offers',
					'action'	 => 'delete_image',
			));

	if(Modules::enabled('site_notifier'))
	{
		Route::set('site_notifier/notifier/offers', TRUE)
			->defaults(array(
				'directory'		=> 'frontend/offers',
				'controller'	=> 'notifier',
				'action'		=> 'index',
			));
	}
}

// ADMIN routes

Route::set('admin_offers_directory', 'admin/offer/<controller>(/<action>(/<id>))', array('id' => '[0-9]+', 'action' => '[a-zA-Z0-9\-_]+'))
	->defaults(array(
		'directory'  => 'admin/offer',
		'action'	 => 'index',
	));

Cron::set('offers_expiring', array('@daily', 'cron/offers/expiring'));
