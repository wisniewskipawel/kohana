<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

return array(
	'ads' => array(
		'ad' => 'Advertising',
		'module' => 'Moduł reklam',
		
		'new_user' => 'new user',
		
		'forms' => array(
			'ad_add' => array(
				'ad_title' => 'Ad Title',
				'ad_description' => 'Ad Details',
				'ad_link' => 'Website',
				'ad_availability' => 'Duration',
				'submit' => 'Place Ad!',
			),
			
			'settings' => array(
				'auto_refresh' => 'Automatyczne odświeżanie (rotacja reklam) w sekundach. Pozostaw to pole puste jeśli bez rotacji.',
			),
			
			'ad_renew' => array(
				'ad_availability' => 'Extend to',
				'submit' => 'Extend',
			),
			
			'validator' => array(
				'add_admin' => array(
					'text_required' => 'Please fill in all required fields!',
					'banner_required' => 'Banner link is required!',
				),
			),
		),
		
		'admin' => array(
			'table' => array(
				'details' => 'Details',
				'ad_date_start' => 'Data rozpoczęcia',
				'action' => array(
					'add' => 'place ad',
				),
			),
			
			'index' => array(
				'title' => 'Reklamy',
				'all' => 'Wszystkie',
				'active' => 'Aktywne',
				'not_active' => 'Nieaktywne',
			),
			
			'users' => array(
				'title' => 'Użytkownicy',
				'count_ads' => 'Ilość reklam',
				'add' => 'place ad',
				'show' => 'show ads',
			),
			
			'payment' => array(
				'title' => 'Płatności reklam',
				'success' => 'Zmiany zostały zapisane!',
			),
			
			'send_promotions' => array(
				'title' => 'Wyślij promocje',
				'success' => 'List został wysłany!',
				'btn' => 'wyślij promocje',
			),
			
			'add' => array(
				'title' => 'Dodawanie reklamy',
				'success' => 'Reklama została dodana!',
				'btn' => 'Dodaj reklamę',
			),
			
			'delete' => array(
				'success' => array(
					'one' => 'Ad has been removed!',
					'many' => 'Ads have been removed!',
				),
			),
			
			'renew' => array(
				'title' => 'Przedłużanie wyświetlania reklamy',
				'success' => 'Wyświetlanie reklamy zostało przedłużone!',
			),
			
			'edit' => array(
				'title' => 'Edit ad',
				'success' => 'Successfully updated!',
			),
			
			'settings' => array(
				'title' => 'Settings',
				'success' => 'Successfully updated!',
			),
		),
	
		'adsystem' => array(
			'title' => 'Adsystem',
			'index' => array(
				'title' => 'Your ads',
			),
		),

		'add_text' => array(
			'title' => 'Place ad',
			'success' => 'Ad has been placed!',
		),

		'payment' => array(
			'link_text' => 'Link tekstowy',
		),
		
		'payments' => array(
			'ad' => array(
				'title'			=> 'Advert',
				'description'	=> 'Advert number :id',
			),
		),
	
		'boxes' => array(
			'half_box' => array(
				'title' => 'Sponsored',
				'add_btn' => 'Place ad',
			),

			'text_link' => array(
				'title' => 'Sponsored',
				'add_btn' => "Place ad &raquo;",
			),
		),
		
		'accept_terms' => 'Accept',
		
		'types' => array(
			Model_Ad::BANNER_A => 'Banner ad A 750x100',
			Model_Ad::BANNER_AB => 'Banner ad AB 750x100',
			Model_Ad::BANNER_AC => 'Banner ad AC 750x100',
			Model_Ad::BANNER_F => 'Banner ad F 750x100',
			Model_Ad::BANNER_B => 'Banner ad B 250x250',
			Model_Ad::TEXT_C => 'Text ad C',
			Model_Ad::TEXT_C1 => 'Text ad C1',
			Model_Ad::SKYCRAPER_D => 'Skycraper banner ad D (left) 120x600',
			Model_Ad::SKYCRAPER_D2 => 'Skycraper banner ad D2 (right) 120x600',
			Model_Ad::BANNER_E => 'Banner ad E 390x250',
			Model_Ad::BANNER_G => 'Banner ad G 750x100',
			Model_Ad::BANNER_J => 'Banner ad J 350x200 (moduł wiadomości)',
			Model_Ad::BANNER_GALLERIES_A => 'Banner ad A 720x100 (moduł galerii)',
			Model_Ad::BANNER_GALLERIES_B => 'Banner ad B 350x250 (moduł galerii)',
			Model_Ad::BANNER_POSTS_A => 'Banner ad K 360x250 (moduł wiadomości)',
		),
	),
	
	'ad_title' => 'Nazwa',
	'ad_type' => 'Typ reklamy',
	'ad_description' => 'Treść - opis', 
	'display_length' => 'Długość wyświetlania', 
	'ad_banner_link' => 'Link do banera', 
	'ad_code' => 'Kod banera', 
	'ad_link' => 'Adres URL strony', 
	'ad_date_start' => 'Data rozpoczęcia wyświetlania',
	'ad_availability' => 'Data zakończenia wyświetlania', 
	'ad_clicks' => 'Limit kliknięć', 
	'ad_clicks_count' => 'Ilość kliknięć',
	'ad_display_count' => 'Ilość wyświetleń',
);