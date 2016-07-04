<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
payment::register_provider('paypal_online');

Route::set('frontend/payment/paypal/ipn', 'payment/paypal/ipn')
        ->defaults(array(
            'directory'         => 'frontend/payment',
            'controller'        => 'paypal',
            'action'            => 'ipn'
        ));

Route::set('frontend/payment/paypal/return', 'payment/paypal/return')
        ->defaults(array(
            'directory'         => 'frontend',
            'controller'        => 'paypal',
            'action'            => 'return'
        ));

Route::set('frontend/payment/paypal/cancel_return', 'payment/paypal/cancel_return')
        ->defaults(array(
            'directory'         => 'frontend',
            'controller'        => 'paypal',
            'action'            => 'cancel_return'
        ));