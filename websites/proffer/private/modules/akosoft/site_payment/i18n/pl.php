<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'payments' => array(
		'title' => 'Płatności',
		
		'total_price' => 'Kwota do zapłaty',
		'discount' => 'Zniżka',
		'date_created' => 'Data rozpoczęcia płatności',
		
		'settings' => array(
			'enable' => 'Płatność za: :name',
		),
		
		'status' => array(
			Model_Payment::STATUS_ERROR => 'błąd',
			Model_Payment::STATUS_NEW => 'nowa',
			Model_Payment::STATUS_SUCCESS => 'zakończona (sukces)',
		),
		
		'pay' => array(
			'title' => 'Aktywacja',
			'details' => 'Szczegóły Usługi',
			'error' => array(
				'default' => 'Wystąpił błąd! Skontaktuj się z administratorem.',
				'not_found' => 'Niepoprawne ID płatności. Skontaktuj się z administratorem strony.',
			),
		),
		
		'new_payment' => array(
			'error' => 'Wystąpił błąd podczas rozpoczynania nowej płatności. Skontaktuj się z administratorem strony.',
		),

		'forms' => array(
			'token' => 'Token',
			
			'payment_method' => array(
				'label' => 'Wybierz',
				'info' => 'Wybierz formę płatności',
				'error' => 'Wybierz metodę płatności!',
				'with_discount' => 'Skorzystaj ze zniżki :discount%',
			),

			'payment_info' => 'Informacje',

			'invoice' => 'Faktura VAT',
			
			'settings' => array(
				'general' => 'Ustawienia ogólne',
				'provider_enabled' => 'Włącz płatność :label',
				
				'payment_disable_tab' => 'Wyłączenie płatności',
				'payment_disable' => 'Wyłączyć płatność za :label',
				
				'providers_tab' => 'Metody płatności',
			),
		),
		
		'admin' => array(
			'table' => array(
				'token' => 'Tytuł płatności (token)',
			),
			
			'status' => array(
				'finish' => 'zakończ',
				'success' => 'sukces',
				'error' => 'błąd',
			),
			
			'index' => array(
				'title' => 'Płatności w serwisie',
			),
			
			'set_status' => array(
				'success' => 'Status został zmieniony!',
			),
			
			'settings' => array(
				'title' => 'Ustawienia płatności',
				'success' => 'Ustawienia zostały zapisane!',
			),
			
			'delete' => array(
				'success' => 'Płatność została usunięta!',
			),
		),
	),
);