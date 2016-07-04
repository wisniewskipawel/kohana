<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

payment::register_provider('payu_online');

Route::set('frontend/payment/payu/ipn', 'payment/payu/ipn/<provider_name>')
        ->defaults(array(
            'directory'         => 'frontend/payment',
            'controller'        => 'payu',
            'action'            => 'ipn'
        ));

Route::set('frontend/payment/payu/success', 'payment/payu/success/<provider_name>')
        ->defaults(array(
            'directory'         => 'frontend',
            'controller'        => 'payu',
            'action'            => 'success'
        ));

Route::set('frontend/payment/payu/error', 'payment/payu/error/<provider_name>')
        ->defaults(array(
            'directory'         => 'frontend',
            'controller'        => 'payu',
            'action'            => 'error'
        ));
