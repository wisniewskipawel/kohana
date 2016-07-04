<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

payment::register_module('ad');

$module = Modules::instance()->register('site_ads');

if ( ! $module->routes()) 
{
	Route::set('site_ads/frontend/ads/add_text_ad_pre', 'ads/add_text_ad_pre')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'ads',
				'action'		=> 'add_text_ad_pre'
			));
	
	Route::set('site_ads/frontend/ads/add_text_ad', 'ads/add_text_ad')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'ads',
				'action'		=> 'add_text_ad'
			));
	
	Route::set('site_ads/frontend/ads/show', 'ads/show/<place>', array('place' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'ad',
				'action'		=> 'show',
				'secure' => TRUE,
			));
	
	Route::set('site_ads/frontend/ads/go_to', 'ads/go_to/<id>', array('id' => '[0-9]+'))
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'ads',
				'action'		=> 'go_to'
			));
	
	Route::set('site_ads/frontend/ads/payment', 'ads/payment')
			->defaults(array(
				'directory'	 => 'frontend',
				'controller'	=> 'ads',
				'action'		=> 'payment'
			));
}

Route::set('adsystem', 'adsystem(/<controller>(/<action>(/<id>)))', array('id' => '[a-zA-Z0-9-_]+'))
	->defaults(array(
		'directory'  => 'adsystem',
		'controller' => 'index',
		'action'	 => 'index',
	));

Cron::set('ads_expiring', array('@daily', 'cron/ads/expiring'));
