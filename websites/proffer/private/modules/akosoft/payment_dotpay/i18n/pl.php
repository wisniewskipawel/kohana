<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'dotpay' => array(
		'forms' => array(
			'validator' => array(
				'code' => 'Kod jest nieprawidłowy!',
			),
			
			'pay' => array(
				'code' => 'Kod promocyjny',
			),
			'submit' => 'Zamówienie z obowiązkiem zapłaty',
		),
		
		'online' => array(
			'title' => 'DotPay Online',
			'buy_link' => 'Wykup',
			'client_id' => 'ID konta DotPay Online (client ID)',
			'delete_codes' => 'Usuwać kody DotPay Online po sprawdzeniu?',
			'texts' => array(
				'title' => 'Teksty płatności',
				'default' => array(
					'label' => 'Skrócona treść płatności',
					'placeholders' => array(
						'title'			=> 'Nazwa opłacanej usługi',
						'price'		=> 'Kwota płatności',
						'link'			=> 'Link płatności DotPay Online',
						'service_id'	=> 'ID usługi płatności',
						'client_id'		=> 'ID klienta DotPay Online',
					),
				),
				'details' => array(
					'label' => 'Szczegóły płatności',
					'placeholders' => array(
						'title'			=> 'Nazwa opłacanej usługi',
						'price'		=> 'Kwota płatności',
						'link'			=> 'Link płatności DotPay Online',
						'service_id'	=> 'ID usługi płatności',
						'client_id'		=> 'ID klienta DotPay Online',
					),
				),
			),
			
			'payment' => array(
				'accounts' => 'DotPay Online - konta',
				'service_id' => 'ID usługi płatności za :title',
				'price' => 'Cena usługi płatności za :title',
			),
			
		),
		
		'sms' => array(
			'title' => 'DotPay SMS',
			'client_id' => 'ID konta DotPay SMS (client ID)',
			'delete_codes' => 'Usuwać kody DotPay SMS po sprawdzeniu?',
			'texts' => array(
				'title' => 'Teksty płatności',
				'default' => array(
					'label' => 'Skrócona treść płatności',
					'placeholders' => array(
						'title'			=> 'Nazwa opłacanej usługi',
						'price'		=> 'Kwota płatności',
						'service_id'	=> 'ID usługi płatności',
						'konektor'		=> 'Numer do wysyłki SMS',
						'client_id'		=> 'ID klienta DotPay SMS',
					),
				),
				'details' => array(
					'label' => 'Szczegóły płatności',
					'placeholders' => array(
						'title'			=> 'Nazwa opłacanej usługi',
						'price'		=> 'Kwota płatności',
						'service_id'	=> 'ID usługi płatności',
						'konektor'		=> 'Numer do wysyłki SMS',
						'client_id'		=> 'ID klienta DotPay SMS',
					),
				),
			),
			
			'payment' => array(
				'accounts' => 'DotPay SMS - konta',
				'service_id' => 'ID usługi płatności za :title',
				'price' => 'Cena usługi płatności za :title',
				'konektor' => 'Numer do wysyłki SMS za :title',
			),
			
		),
	),
);