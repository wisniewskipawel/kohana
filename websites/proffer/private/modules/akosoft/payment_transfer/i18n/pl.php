<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'transfer' => array(
		'provider' => array(
			'label' => 'Przelew bankowy',
			'bank_account_number' => 'Numer konta bankowego',
			'address_information' => 'Dane adresowe do wykonania przelewu',
			'texts' => array(
				'title' => 'Teksty płatności',
				'default' => array(
					'label' => 'Skrócona treść płatności',
				),
				'placeholders' => array(
					'title'			=> 'Nazwa opłacanej usługi',
					'price'		=> 'Kwota płatności',
				),
			),
		),
		'module' => array(
			'price' => 'Cena (kwota) za :title',
		),
		'details' => array(
			'payment_title' => 'Proszę o wykonanie płatności za',
			'info' => 'Dane do wykonania przelewu',
			'bank_account_number' => 'Numer konta bankowego',
			'transfer_title' => 'Tytuł przelewu',
			'transfer_price' => 'Kwota przelewu',
			'address_information' => 'Dane kontaktowe',
		),
	),
);