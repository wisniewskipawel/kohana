<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'url' => 'https://www.paypal.com/cgi-bin/webscr',
	'notify_url' => Route::url('frontend/payment/paypal/ipn', NULL, 'http'),
	'return' => Route::url('frontend/payment/paypal/return', NULL, 'http'),
	'cancel_return' => Route::url('frontend/payment/paypal/cancel_return', NULL, 'http'),
	'currency_code' => 'PLN',

	'ignored_types' => array(),
);
