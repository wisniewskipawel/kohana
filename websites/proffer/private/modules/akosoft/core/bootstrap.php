<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

Kohana::add_modules('modules', array(
	'image'				=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'image',
	'orm'				=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'orm',
	'mpdf'				=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'mpdf',
	'cron'				=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'cron',
	'akosoft/emails'	=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'emails',
	'akosoft/forms'		=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'forms',
	'akosoft/modules'	=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'modules',
	'akosoft/images'	=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'images',
));

if(Kohana::$environment == Kohana::DEVELOPMENT)
{
	if(file_exists(DOCROOT.'private'.DIRECTORY_SEPARATOR.'modules_dev'.DIRECTORY_SEPARATOR.'bootstrap.php'))
	{
		include DOCROOT.'private'.DIRECTORY_SEPARATOR.'modules_dev'.DIRECTORY_SEPARATOR.'bootstrap.php';
	}
}

Kohana::add_modules('payments', array(
	'site_payment'			=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'site_payment',
	'payment_dotpay'		=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'payment_dotpay',
	'payment_payu'			=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'payment_payu',
	'payment_paypal'		=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'payment_paypal',
	'payment_transfer'		=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'payment_transfer',
	'payment_transferuj'	=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'payment_transferuj',
));

// load modules
Modules::load();

Kohana::add_modules('helpers', array(
	'breadcrumbs'		=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'breadcrumbs',
	'captcha'			=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'captcha',
	'pagination'		=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'pagination',
	'regions'			=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'regions',
	'kohana-sitemap'	=> MODPATH.'kohana'.DIRECTORY_SEPARATOR.'sitemap',
	'akosoft_sitemap'	=> MODPATH.'akosoft'.DIRECTORY_SEPARATOR.'sitemap',
));

//Configure image driver
img::init();

//routes

Route::set('media/compiled/file', 'media/compiled/<filename>', array('filename' => '[a-zA-Z0-9\-\_\.\/]+'))
	->defaults(array(
		'directory'		=> NULL,
		'controller'	=> 'media',
		'action'		=> 'file',
		'subdomain'	=> TRUE,
	));

Route::set('media/file', 'media/<filename>', array('filename' => '[a-zA-Z0-9\-\_\.\/]+'))
	->defaults(array(
		'directory'		=> NULL,
		'controller'	=> 'media',
		'action'		=> 'file',
		'subdomain'	=> TRUE,
	));

Route::set('rss', 'rss/<controller>/<action>(/<id>)', array('id' => '[0-9]+'))
	->defaults(array(
		'directory'		=> 'rss',
		'action'		=> 'index',
	));

Route::set('install', 'install(/<action>(/<id>))', array('id' => '[0-9]+'))
	->defaults(array(
		'controller'	=> 'install',
		'action'		=> 'index',
	));

//default routes

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))', array('id' => '[a-zA-Z0-9-_]+'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'index',
		'action'	 => 'index',
	));

Route::set('ajax', 'ajax(/<controller>(/<action>(/<id>)))', array('id' => '.*'))
	->defaults(array(
		'directory'  => 'ajax',
		'controller' => 'index',
		'action'	 => 'index',
		'subdomain'	=> TRUE,
	));

Route::set('cron/run', 'cron/run/<token>')
	->defaults(array(
		'controller' => 'Cron',
		'action'	 => 'run',
	));

Route::set('cron/execute', 'cron/execute')
	->defaults(array(
		'controller' => 'cron',
		'action'	 => 'execute',
	));

Route::set('cron', 'cron(/<controller>(/<action>(/<id>)))', array('id' => '.*'))
	->defaults(array(
		'directory'  => 'cron',
		'controller' => 'index',
		'action'	 => 'index',
	));

Route::set('profile', 'profil(/<controller>(/<action>(/<id>)))', array('id' => '[0-9]+'))
	->defaults(array(
		'directory'  => 'profile',
		'controller' => 'index',
		'action'	 => 'index',
	));

Route::set('index', '')
	->defaults(array(
		'directory' => 'frontend',
		'controller' => 'index',
		'action' => 'index',
	));

if(Site::current_subdomain_module())
{
	Cookie::$domain = '.'.Kohana::$config->load('site.server_name');
}

Cron::set('akosoft_check', array('@daily', 'cron/akosoft/check'));
