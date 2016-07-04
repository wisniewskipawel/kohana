<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'paypal' => array(
		'buy_btn' => 'Make a payment',
		
		'provider' => array(
			'label' => 'PayPal',
			'settings' => array(
				'business' => 'PayPal email address',
				'return' => 'Adres powrotu:',
				'cancel_return' => 'Adres powrotu - anulowana',
				'ipn' => 'Adres raportów',
				
				'texts' => array(
					'title' => 'Teksty płatności',
					'default' => array(
						'label' => 'Skrócona treść płatności',
						'placeholders' => array(
							'title'			=> 'Nazwa opłacanej usługi',
							'price'		=> 'Price',
						),
					),
					'details' => array(
						'label' => 'Payment details',
						'placeholders' => array(
							'title'			=> 'Nazwa opłacanej usługi',
							'price'		=> 'Price',
						),
					),
				),
			),
		),
		
		'module' => array(
			'title' => 'Paypal - prices',
			'price' => array(
				'label' => "Price for :title",
			),
		),
		
		'return' => array(
			'success' => 'Your payment has been successfully processed. Thank you.',
		),
		'cancel_return' => array(
			'error' => 'Your payment can’t be completed. Please return to the participating website and try again!',
		),
	),
);