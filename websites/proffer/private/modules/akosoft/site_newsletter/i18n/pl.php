<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'newsletter' => array(
		'title' => 'Newsletter',
		'module' => 'Moduł newslettera',
		
		'emails_sent_counter' => 'Liczba wysłanych maili',
		'accept_ads' => 'Akceptuje reklamy partnerów',
		'yes' => 'TAK',
		'no' => 'NIE',
		'is_active' => 'Aktywny',
		
		'unsubscribe_btn' => 'Wypisz się',
		
		'subscribe' => array(
			'success' => 'Zostałeś zapisany do newslettera!',
			'error' => 'Nie zostałeś zapisany do newslettera!',
		),
		
		'unsubscribe' => array(
			'title' => 'Zostałeś wypisany z newslettera!',
			'success' => 'Zostałeś pomyślnie wypisany z newslettera!',
		),
		
		'confirmation' => array(
			'title' => 'Zostałeś zapisany do newslettera!',
			'success' => 'Twój adres e-mail został aktywowany!',
		),
		
		'forms' => array(
			'send' => array(
				'letter_subject' => 'Temat',
				'letter_message' => 'Wiadomość',
				'letter_message_placeholders' => array(
					'unsubscribe' => 'Przycisk "Wypisz się"',
				),

				'queue_send_at' => 'Data wysyłki', 
				'accepted_ads' => 'Wyślij do', 
				'accepted_ads_values' => array(
					'all' => 'wyślij wiadomość z serwisu',
					'accepted_ads' => 'wyślij reklamę partnerów (tylko do akceptujących)',
				),
			),
			
			'cron_freq' => 'Częstotliwość wywoływania CRONa z wysyłką newslettera.',
			
			'cron_freq_values' => array(
				'daily'		=> 'raz dziennie',
				'hours' => array(
					'one' => 'co godzinę',
					'few' => 'co :nb godziny',
					'other' => 'co :nb godzin',
				),
				'minutes' => array(
					'one' => 'co minutę',
					'few' => 'co :nb minuty',
					'other' => 'co :nb minut',
				),
			),
			'submit_text' => 'Treść informacji o konieczności potwierdzeniu zapisania do newslettera',
		),
		
		'boxes' => array(
			'sidebar' => array(
				'title' => 'Newsletter',
				'info' => 'Zapisz się do newslettera.',
				'enter_email' => 'Wpisz e-mail',
				'accept' => array(
					'yes' => 'TAK',
					'no' => 'NIE'
				)
			),
		),
		
		'overlay' => array(
			'title' => 'Zapisz się do naszego newslettera',
			'info' => 'Podaj swój adres e-mail aby zapisać się do newslettera i otrzymywać oferty.',
			'privacy_info' => 'Zapisując się do newslettera akceptujesz naszą :privacy_link',
			'privacy_link_title' => 'politykę prywatności',
		),
		
		'admin' => array(
			
			'start_date' => 'Data rozpoczęcia wysyłki',
			'emails_left' => 'Pozostało do wysłania',
			
			'send' => array(
				'title' => 'Wyślij wiadomość do subskrybentów',
				'menu' => 'Wyślij wiadomość',
				'success' => 'Wiadomość została wysłana!',
			),
			
			'queue' => array(
				'title' => 'Kolejka wiadomości',
			),
			
			'show' => array(
				'title' => 'Podgląd listu',
			),
			
			'cancel' => array(
				'btn' => 'anuluj wysyłkę',
				'success' => 'Wysyłka została anulowana!',
			),
			
			'settings' => array(
				'title' => 'Ustawienia newslettera',
				'success' => 'Zmiany zostały zapisane!',
			),
			
			'subscribers' => array(
				'title' => 'Subskrybenci',

				'delete' => array(
					'success' => array(
						'one' => 'Subskrybent został usunięty!',
						'many' => 'Subskrybenci zostali usunięci!',
					),
				),
			),
		),
	),
);