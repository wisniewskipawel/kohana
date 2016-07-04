<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'notifiers' => array(
		'title' => 'Powiadamiacz',
		'module_name' => 'Moduł powiadamiacza',
		'notifier_btn' => "&star; Create an alert for this search",
		
		'module' => 'Moduł',
		'check_all' => 'select all',
		
		'forms' => array(
			'email' => 'Your email',
			'province' => array(
				'label' => 'County',
				'all' => '---',
			),
			'categories' => 'Select categories',
			'notify' => 'notify me of updates on the site',
			'all' => '---',
			'status' => array(
				'active' => 'Active',
				'not_active' => 'Not active',
			),
			
			'settings' => array(
				'header_tab_title' => 'Nazwa zakładki w menu głównym',
				'send_confirmation' => 'Wysyłaj potwierdzenie zapisania',
			),
			
		),
		
		'confirm' => array(
			'success' => 'Your email address has been verified!',
			'error' => 'An error occured, please try again later!',
		),
		
		'unsubscribe' => array(
			'success' => 'You have been unsubscribed!',
			'error' => 'An error occured, please try again later!',
		),
		
		'boxes' => array(
			'nav' => array(
				'title' => 'Moduł powiadamiacza',
			),
		),
		
		'admin' => array(
			
			'index' => array(
				'title' => 'Zapisani do powiadamiacza',
			),
			
			'edit' => array(
				'title' => 'Edit',
				'success' => 'Changes have been saved!',
			),
			
			'settings' => array(
				'title' => 'Manage your saved searches',
				'success' => 'Changes have been saved!',
			),
			
		),
	),
	
	'site_notifier/home' => 'alert',
	'site_notifier/frontend/notifier/confirmation' => 'alert/confirm/<id>(/<token>)',
	'site_notifier/frontend/notifier/unsubscribe' => 'alert/unsubscribe/<id>(/<token>)',
);