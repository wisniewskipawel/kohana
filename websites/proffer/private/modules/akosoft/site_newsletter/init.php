<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
$module = Modules::instance()->register('site_newsletter');

Route::set('admin_newsletter_subscribers', 'admin/newsletter/subscribers(/<action>(/<id>))')
		->defaults(array(
			'directory'		 => 'admin/newsletter',
			'controller'		=> 'subscribers',
			'action'			=> 'index'
		));

Route::set('site_newsletter/frontend/newsletter/submit', 'newsletter/submit')
		->defaults(array(
			'directory'		 => 'frontend',
			'controller'		=> 'newsletter',
			'action'			=> 'submit'
		));

Route::set('site_newsletter/frontend/unsubscibe', 'newsletter/unsubscibe/<id>/<token>')
		->defaults(array(
			'directory'		 => 'frontend',
			'controller'		=> 'newsletter',
			'action'			=> 'unsubscibe'
		));

Route::set('site_newsletter/frontend/confirmation', 'newsletter/confirmation/<id>/<token>')
		->defaults(array(
			'directory'		 => 'frontend',
			'controller'		=> 'newsletter',
			'action'			=> 'confirmation'
		));

if(Kohana::$environment !== Kohana::DEMO)
{
	Cron::set('newsletter_send', array(Arr::get(Kohana::$config->load('modules.site_newsletter.settings'), 'cron_freq', '@daily'), 'cron/newsletter/send'));
}