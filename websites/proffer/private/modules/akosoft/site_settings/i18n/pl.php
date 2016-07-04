<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

return array(
	'settings' => array(
		'title' => 'Ustawienia',
		
		'general_tab' => 'Ogólne',
		
		'security' => array(
			'title' => 'Zabezpieczenia',
			'success' => 'Ustawienia zostały zmienione!',
			
			'riddles' => array(
				'title' => 'Pytania zabezpieczające',
				'question' => 'Pytanie',
				'answers' => 'Odpowiedzi',
				'no_results' => 'Brak pytań zabezpieczających!',
				
				'add' => array(
					'title' => 'Dodaj nowe pytanie',
					'btn' => 'Dodaj nowe pytanie',
					'success' => 'Pytanie zostało dodane!',
				),
				
				'edit' => array(
					'title' => 'Edytuj pytanie',
					'success' => 'Pytanie zostało zmienione!',
				),
				
				'delete' => array(
					'success' => 'Zmiany zostały zapisane!',
				),
			)
		),
		
		'site' => array(
			'title' => 'Ustawienia strony',
			'success' => 'Ustawienia zostały zmienione!',
		),
		
		'appearance' => array(
			'title' => 'Ustawienia wyglądu',
			'success' => 'Ustawienia zostały zmienione!',
			
			'form' => array(
				
				'general_tab' => 'Ogólne',
				'site' => array(
					'template_style' => 'Wybierz styl strony', 
				),
				
				'layout_tab' => 'Edycja pliku szablonu',
				'layout' => array(
					'google_analytics_account' => 'Identyfikator śledzenia Google Analytics (UA-XXXXX-X)', 
					'copyright_text' => 'Tekst copyright w stopce', 
					'home_header_text' => 'Tekst H1 na stronie głównej', 
					'cookie_alert' => array(
						'enabled' => 'Włącz informację o plikach cookie', 
						'text' => 'Treść informacji o plikach cookie', 
					),
					'overlay' => array(
						'type' => 'Wybierz rodzaj Overlaya', 
					),

					'hot_info_slider' => array(
						'label' => 'HOT Info',
						'enabled' => 'Włącz komunikat HOT Info',
						'url' => 'Adres URL',
						'text' => 'Treść komunikatu',
						'color' => 'Kolor tekstu',
						'background' => 'Kolor tła',
					),
				),
			),
		),
		
		'agreements' => array(
			'title' => 'Zgody',
			'success' => 'Ustawienia zostały zmienione!',
		),
		
		'modules' => array(
			'title' => 'Ustawienia modułów',
			'success' => 'Ustawienia zostały zmienione!',
		),
				
		'change_password' => array(
			'title' => 'Zmień hasło',
			'menu' => 'Zmień hasło i edytuj konto',
			'success' => 'Konto zostało edytowane!',
		),
		
		'test_email' => array(
			'title' => 'Test wysyłki',
			'btn' => 'Testuj wysyłkę e-mail',
			'btn_after' => '(dopiero po zapisaniu ustawień)',
			'success' => 'E-mail został poprawnie wysłany!',
			'error' => 'Wystąpił błąd! Sprawdź konfiguracje i spróbuj ponownie. :error',
		),
		
		'forms' => array(
			'riddles' => array(
				'question' => 'Pytanie',
				'answers' => 'Odpowiedzi', 
				'answers_info' => 'Podaj prawidłowe odpowiedzi na pytanie, jedna na linię. 
					Dopasowanie odpowiedzi jest ścisłe. Jeśli odpowiedź ma być z dużej lub małej litery, zapisz dwie odpowiedzi.'
			),
			
			'security' => array(
				'type' => 'Wybierz rodzaj zabezpieczenia',
				'types' => array(
					'riddles' => 'Pytania',
				),
				'riddles_link' => 'Kliknij tutaj, żeby przejść do konfiguracji pytań zabezpieczających',
				'forms' => 'Zabezpieczenia formularzy',
			),
			
			'site' => array(
				'email_tab' => 'E-mail',
				'smtp_tab' => 'Ustawienia SMTP',
				
				'email' => array(
					'from' => 'Adres email od którego będą pochodzić wysłane maile',
					'from_name' => 'Nazwa od której będą pochodzić wysłane maile',
					'to' => 'Adres email na który będą przychodzić emaile z serwisu',
					'send_function' => 'Rodzaj funkcji do wysyłki emaili', 
					'smtp' => array(
						'hostname' => 'Serwer SMTP', 
						'username' => 'Użytkownik SMTP', 
						'password' => 'Hasło SMTP',
						'port' => 'Port SMTP', 
						'encryption' => 'Zabezpieczenia SMTP', 
						'encryption_none' => 'brak', 
					),
				),
				
				'meta_tab' => 'META tagi',
				'modules_tab' => 'Ustawienia modułów',
				
				'site' => array(
					'meta' => array(
						'title' => 'Tytuł strony',
						'keywords' => 'META słowa kluczowe',
						'description' => 'META opis strony',
						'robots' => 'Meta robots',
					),
					'home_module' => 'Moduł strony głównej',
					'subdomain_module' => 'Moduł subdomen',
					'subdomain_module_info' => 'Określ który moduł będzie korzystał z wizytówek w subdomenie',
					'disabled' => 'Wyłącz stronę (prace konserwacyjne)',
					'disabled_text' => 'Treść strony "Prace konserwacyjne"', 
					'url' => 'Adres WWW serwisu',
					'current_logo' => 'Obecne logo',
					'logo' => 'Podmień logo', 
					
					'watermark' => array(
						'enabled' => 'Włącz znak wodny', 
						'current_watermark' => 'Obecny znak wodny',
						'watermark_image' => 'Wybierz znak wodny z dysku (maksymalny rozmiar 250x250px lub zostanie automatycznie zmniejszony)', 
						'opacity' => 'Poziom przeźroczystości (1-100 - im większa wartość, tym wyraźniej widoczny)',
						'placement' => 'Położenie znaku wodnego',
					),
					'enable_https' => 'Włącz połączenia HTTPS na wrażliwych stronach',
					'enable_https_info' => 'Wymaga odpowiednio skonfigurowanego serwera',
				),
				
				'other_tab' => 'Pozostałe',
				'sitemap' => array(
					'cache_lifetime' => 'Generuj nową mapę witryny co (dni)', 
				),
				
				'watermark_tab' => 'Znak wodny',
				'watermark_placements' => array(
					'top_left' => 'Lewy górny róg',
					'top_right' => 'Prawy górny róg',
					'bottom_left' => 'Lewy dolny róg',
					'bottom_right' => 'Prawy dolny róg',
					'top_center' => 'Górny środek',
					'bottom_center' => 'Dolny środek',
				),
				'watermark_requirements_error' => array(
					'label' => 'Błąd!',
					'content' => 'Twój hosting nie spełnia wymogów dla tej opcji!',
				),
				
				'cron_tab' => 'CRON',
				'cron_link' => 'Link do wywołania CRON: :url',
			),
			
			'agreements' => array(
				'agreements' => array(
					'terms' => 'Zasady',
					'trading' => 'Zgoda na informacje handlowe',
					'ads' => 'Zgoda na działania marketingowe',
				),
			),
		),
	),
	
	'meta_tags.meta_tab' => 'Tagi META',
	'meta_tags.module_meta_tab' => 'Tagi META modułu',
	'meta_tags.meta_title' => 'META title',
	'meta_tags.meta_description' => 'META description',
	'meta_tags.meta_keywords' => 'META keywords',
	'meta_tags.meta_robots' => 'META robots',
	'meta_tags.meta_revisit_after' => 'META revisit after',
);