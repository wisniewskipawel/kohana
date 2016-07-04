<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

return array(
	'products' => array(
		'title' => 'Products & Services',
		'module' => 'Products Module',
		
		'sort' => array(
			'closet' => 'Kolejność w schowku',
		),
		
		'list' => array(
			'see_more_btn' => 'View Details',
			'company_products_btn' => 'See other items',
			'no_results' => 'No results!',
			'show_btn' => 'Details',
			'promote' => 'Upgrade',
			'closet' => 'Watchlist',
			
			'tabs' => array(
				'all' => 'All',
				1 => 'Available',
				2 => 'On order',
			),
		),
		
		'layout' => array(
			'add_btn' => 'SELL A <strong>PRODUCT</strong>',
			'counter' => array(
				'one' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>PRODUCTS & SERVICES<strong></span><br>Buy & Sell products, Provide & compare services on Proffer!',
				'few' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>PRODUCTS & SERVICES<strong></span><br>Buy & Sell products, Provide & compare services on Proffer!',
				'other' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>PRODUCTS & SERVICES<strong></span><br>Buy & Sell products, Provide & compare services on Proffer!',
			),
		),
		
		'person_types' => array(
			'person' => 'Individual',
			'company' => 'Pro',
		),
		
		'pre_add' => array(
			'add_btn' => 'Post a Product without registration',
		),

		'add' => array(
			'title' => 'Post a Product for Sale',
			'btn' => 'Post a Product',
			'info' => 'Sell your Products & Services for FREE!',
			'success' => array(
				'default' => 'Product has been posted!',
				'payment' => 'Product has been posted! Choose an upgrade to make a Deal active.',
				'moderate' => 'Product has been posted! Products posted without registration appear after approval by admin.',
			),
		),
		
		'approve' => array(
			'success' => 'Product has been activated!',
		),
		
		'report' => array(
			'title' => 'Report',
			'success' => 'Product has been reported!',
		),
		
		'category' => array(
			'title' => 'All in :category',
		),
		
		'send' => array(
			'title' => 'Email this Product to a friend',
			'success' => 'Product has been sent!',
		),
		
		'advanced_search' => array(
			'title' => 'Advanced search',
		),
		
		'search' => array(
			'title' => 'Search Products',
			'results' => 'Search results',
			'no_results' => 'No Products found!',
			'phrase' => array(
				'placeholder' => 'Search Product...',
				'error' => 'Search by keyword!',
			),
		),
		
		'promoted' => array(
			'title' => 'Featured Products',
		),
		
		'promote' => array(
			'title' => 'Promoting your Product with listing upgrades',
			'success' => 'Product has been featured!',
			'no_promotion' => array(
				'title' => 'Post a Product without any upgardes',
				'btn' => 'No upgrades',
			),
			'types' => array(
				Model_Product::DISTINCTION_PREMIUM => array(
					'title' => 'Promuj produkt na stronie głównej',
					'description' => '<strong>Produkty Premium</strong> prezentowane są losowo na stronie głównej oraz w "ramce" zawsze na początku wyników kategorii.',
					'disabled' => 'Ten sposób promowania jest wyłączony!',
				),
			),
			
			'company_free' => array(
				'title' => 'Free upgrade with Premium Plus',
				'error' => 'An error occurred!',
			),
		),
		
		'distinctions' => array(
			Model_Product::DISTINCTION_PREMIUM => 'Premium', 
			Model_Product::DISTINCTION_NONE => 'none',
		),
		
		'show_by_user' => array(
			'title' => 'Produkty użytkownika :user',
			'btn' => 'Zobacz inne produkty użytkownika',
		),
		
		'show_by_company' => array(
			'title' => 'Products by :company_name',
		),
		
		'show' => array(
			'title' => 'Product',
			
			'product_info' => 'Informacje o produkcie',
			'availability' => 'Product',
			'manufacturer' => 'Producer',
			'person_info' => array(
				'person' => 'Seller details',
				'company' => 'Pro details',
			),
			'buy' => 'Buy Now',
			'buy_shop' => 'on seller website',
			'buy_allegro' => 'on eBay',
			'buy_here' => 'on Proffer',
			'product_content' => 'Description',
			'price_negotiable' => 'negotiable',
		),
		
		'index' => array(
			'title' => 'All Products & Services',
		),
		
		'tag' => array(
			'title' => 'Search results for ":tag"',
		),
		
		'order' => array(
			'title' => 'Ordering a Product or Service',
			'success' => 'Order has been sent! Expect a seller reply to complete your purchase.',
			'error' => array(
				'product_state' => 'Product is not available!',
			),
			'ordering_product' => 'Your order',
		),
		
		'contact' => array(
			'info' => 'Send message to the seller.',
			'success' => 'Message has been sent!',
		),
		
		'rss' => array(
			'index' => array(
				'title' => 'Recently posted',
				'description' => 'Recently posted on :site_name',
			),
			'category' => array(
				'title' => 'Recently posted in :category',
				'description' => 'Recently posted in :category on :site_name',
			),
		),
		
		'payments' => array(
			'product_promote' => array(
				'title'			=> 'Upgrade a Product',
				'description'	=> 'Upgrade a Product :product_title (:distinction)',
			),
			'product_add' => array(
				'title'			=> 'Post a Product.',
				'description'	=> 'Post a Product :product_title',
			),
		),
		
		'company' => array(
			'see_all_btn' => 'See other items...',
		),
		
		'forms' => array(
			'availability' => 'Availability',
			
			'types' => array(
				'name' => 'Name',
			),
			
			'category_id' => 'Category',
			'product_type' => 'Type',
			'product_manufacturer' => 'Brand', 
			'product_title' => 'Title',
			'product_content' => 'Description', 
			'product_state' => 'Availability', 
			'product_states' => array(
				0 => 'not available',
				1 => 'available',
				2 => 'on order',
			),
			'product_buy' => 'Sell on Proffer',
			'product_allegro_url' => 'eBay', 
			'product_shop_url' => 'Website', 
			'product_price' => 'Price', 
			'product_price_to_negotiate' => 'Price negotiable',
			'product_person_type' => 'Individual / Pro',
			'person_types' => array(
				'person' => 'Individual',
				'company' => 'Pro',
			),
			'product_person' => 'Full name / Pro',
			'product_person_labels' => array(
				'person' => 'Full name',
				'company' => 'Pro',
			),
			'product_tags' => 'Keywords (separated by commas)', 
			'product_availability' => 'Displayed until', 
			'product_availability_span' => 'Duration',
			'product_distinction' => 'Upgrade type', 
			'product_promotion_availability' => 'Featured from', 
			'company' => 'Pro',
			'product_map' => 'Specify the exact location on the map', 
			
			'advanced_search' => array(
				'phrase' => 'Keyword',
				'where' => 'Search in', 
				'where_values' => array(
					'title_and_description'	 => 'title and description',
					'title'					 => 'title',
					'description'			 => 'description',
				),
				'price_from' => 'Price €', 
				'price_to' => 'to', 
			),
			
			'order' => array(
				'quantity' => 'Quantity', 
				'person_type' => 'Individual / Pro',
				'person_type_values' => array(
					'private' => 'Individual',
					'company' => 'Pro',
				),
				'name' => 'Full name', 
				'company_name' => 'Pro', 
				'company_nip' => 'VAT', 
				'remarks' => 'Remarks', 
			),
			
			'send' => array(
				'email' => 'Friend’s email',
			),
			
			'contact' => array(
				'email' => 'Email',
				'subject' => 'Title',
				'message' => 'Details',
			),
			
			'renew' => array(
				'product_availability' => 'Renew to',
			),
		
			'images' => array(
				'error' => array(
					'max' => 'You can upload up to :nb',
				),
			),
			
			'settings' => array(
				'general_tab' => 'Ogólne',
				
				'header_tab_title' => 'Nazwa zakładki w menu głównym',
				'provinces_enabled' => 'Włącz województwa',
				'confirm_required' => 'Włącz potwierdzenia produktów dla użytkowników niezarejestrowanych',
				'confirmation_email' => 'Wysyłaj powiadomienie do administratorów o akceptację produktu',
				'email_view_disabled' => 'Wyłącz pokazywanie adresu e-mail na podstronie produktu',
				'home_box_products' => 'Ilość produktów w boksie "Polecane produkty" na stronie głównej modułu', 
				'photos_count' => array(
					'guest' => 'Liczba zdjęć dla użytkowników niezalogowanych', 
					'registered' => 'Liczba zdjęć dla użytkowników zalogowanych', 
				),
				'promotion_time' => 'Liczba dni promowania produktu',
				'free_promotion' => 'Ilość produktów promowanych bezpłatnie w ramach wpisu firmy: :company_promotion_name',
				
				'add_form_tab' => 'Formularz dodawania produktu',
				'promote_tab' => 'Promowanie produktów',
			),
		),
		
		'profile' => array(
			
			'stats' => array(
				'count_products' => 'Posted Products: <strong>:nb</strong>',
				'count_active_products' => 'Active Products: <strong>:nb</strong> :link',
				'active_products_link' => 'view',
			),
			
			'my' => array(
				'title' => 'My Products & Services',
				'list' => array(
					'days_left' => array(
						'one' => 'Active: :days_left day left',
						'other' => 'Active: :days_left days left',
					),
					'inactive' => 'Expired',
				),
			),
			
			'delete' => array(
				'success' => 'Product has been removed!',
			),
			
			'statistics' => array(
				'title' => 'Products & Services Statistics',
				'product_visits' => 'Views',
			),
			
			'renew' => array(
				'title' => 'Przedłużanie wyświetlania produktu',
				'success' => 'Wyświetlanie produktu zostało przedłużone!',
				'error_days_left' => array(
					'one' => 'You can renew this Product tomorrow.',
					'other' => 'You can renew this Product in :days_left days.',
				),
			),
			
			'edit' => array(
				'title' => 'Edit Product',
				'success' => 'Product has been updated!',
			),
			
			'closet' => array(
				'title' => 'Saved Products & Services',
				'tab' => 'Products & Services (:nb)',
				
				'add' => array(
					'success' => 'This Product has been added to your watchlist!',
				),
				
				'delete' => array(
					'success' => 'This Product has been removed from your watchlist!',
				),
			),
			
		),
		
		'admin' => array(
			
			'which' => array(
				'all' => 'Wszystkie produkty',
				'standard' => 'Produkty standardowe',
				'promoted' => 'Produkty wyróżnione',
				'not_active' => 'Produkty nieaktywne',
				'active' => 'Produkty aktywne',
				'not_approved' => 'Produkty oczekujące',
			),
			
			'users' => array(
				'products_normal_count' => 'Produkty zwykłe',
				'products_promoted_count' => 'Produkty promowane',
				
				'action_links' => array(
					'title' => 'pokaż produkty',
				),
			),

			'categories' => array(
				'title' => 'Kategorie',
				'browse' => 'Przeglądaj kategorie',

				'add' => array(
					'title' => 'Dodawanie kategorii',
					'btn' => 'Dodaj kategorię',
					'success' => 'Kategoria została dodana!',
				),
				'edit' => array(
					'title' => 'Edytowanie kategorii',
					'success' => 'Zmiany w kategorii zostały zapisane!',
				),

				'ordering' => array(
					'success' => 'Kolejność została zmieniona!',
				),

				'delete' => array(
					'success' =>  array(
						'one' => 'Kategoria została usunięta!',
						'many' => 'Kategorie zostały usunięte!',
					),
				),

				'delete_icon' => array(
					'success' => 'Ikonka została usunięta!',
				),

				'forms' => array(
					'add' => array(
						'general_tab' => 'Ogólne',
						'seo' => 'SEO',
					),
					'icon' => 'Ikonka kategorii',
					'delete_icon' => 'usuń',
				),

				'show_products_btn' => 'pokaż produkty',
				'subcategory_add_btn' => 'dodaj podkategorię',
				'products_count' => 'Ilość produktów',
			),
			
			'availabilites' => array(
				'index' => array(
					'title' => 'Okresy wyświetlania',
					'availability' => 'Liczba dni',
				),
				
				'add' => array(
					'title' => 'Dodaj okres wyświetlania',
					'success' => 'Okres wyświetlania produktu został dodany!',
				),
				
				'edit' => array(
					'title' => 'Edytuj okres wyświetlania',
					'success' => 'Okres wyświetlania produktu został zmieniony!',
				),
				
				'delete' => array(
					'success' => 'Okres wyświetlania został usunięty!',
				),
			),
			
			'types' => array(
				'index' => array(
					'title' => 'Typy produktów',
					'name' => 'Nazwa',
					'count_products' => 'Ilość produktów',
				),
				
				'add' => array(
					'title' => 'Dodawanie typu produktu',
					'menu' => 'Dodaj typ produktu',
					'success' => 'Typ produktu został dodany!',
				),
				
				'edit' => array(
					'title' => 'Edytuj typ produktu',
					'success' => 'Zmiany w typie produktu zostały zapisane!',
				),
				
				'delete' => array(
					'success' => 'Typ produktu został usunięty!',
				),
			),
			
			'stats' => array(
				'title' => 'Statystyki produktów',
				'categories_count' => 'Liczba kategorii',
				'subcategories_count' => 'Liczba podkategorii',
				'active_products_count' => 'Liczba aktywnych produktów',
				'not_active_products_count' => 'Liczba nieaktywnych produktów',
				'to_approve_products_count' => 'Liczba produktów do zaakceptowania',
			),
			
			'index' => array(
				'menu' => 'Przeglądaj produkty',
				'search_pk' => 'Szukaj produktu po ID',
				'which' => 'Wyświetl',
				'product_title' => 'Nazwa produktu',
				'promotion' => array(
					'title' => 'Promowanie',
					'yes' => 'TAK',
					'no' => 'nie',
					'promote' => 'promuj',
				),
				'user' => 'Użytkownik',
				'approve' => 'potwierdź',
			),
			
			'add' => array(
				'title' => 'Dodawanie produktu',
				'menu' => 'Dodaj produkt',
				'success' => 'Produkt został dodany!',
			),
			
			'renew' => array(
				'title' => 'Przedłużanie wyświetlania produktu',
				'success' => 'Wyświetlanie produktu zostało przedłużone!',
			),
			
			'edit' => array(
				'title' => 'Edycja produktu',
				'success' => 'Zmiany w produkcie zostały zapisane!',
			),
			
			'promote' => array(
				'title' => 'Promowanie produktu',
				'success' => 'Produkt został wypromowany!',
			),
			
			'settings' => array(
				'title' => 'Ustawienia produktów',
				'success' => 'Ustawienia produktów zostały zapisane!',
			),
			
			'payments' => array(
				'title' => 'Płatności produktów',
				'success' => 'Płatności produktów zostały zapisane!',
				
				'enabled_values' => array(
					'disabled'	=> 'wyłączona',
					'all'		=> 'włączona dla wszystkich',
					'not_registered'	=> 'włączona dla niezarejestrowanych',
				),
				
				'product_add' => array(
					'title' => 'Płatność za Dodawanie produktu',
				),
			),
			
			'approve' => array(
				'success' => array(
					'one' => 'Produkt został zaakceptowany!',
					'many' => 'Produkty zostały zaakceptowane!',
				),
			),
			
			'delete' => array(
				'title' => 'Usuwanie produktu',
				'success' => array(
					'one' => 'Produkt został usunięty!',
					'many' => 'Produkty zostały usunięte!',
				),
			),
		),
		
		'boxes' => array(
			'home' => array(
				'title' => 'Recommended',
			),
			'category_products' => array(
				'title' => 'Recommended',
			),
			'categories' => array(
				'title' => 'Category',
			),
			'promoted_sidebar' => array(
				'title' => 'Featured',
			),
			'tags' => array(
				'title' => 'Product Tags',
			),
			'similar' => array(
				'title' => 'You might also like',
			),
			'promoted' => array(
				'title' => 'Products & Services',
			),
			'modules' => array(
				'title' => 'Products & Services',
				'add_btn' => 'Post a Product',
			),
		),
		
		'email' => array(
			'expiring' => array(
				'renew_link' => 'Renew',
				'add_link' => 'Post a Product without registration',
			),
			'report' => array(
				'subject' => 'Naruszenie zasad w serwisie',
			),
			'order' => array(
				'company_name' => ':company_name (VAT :nip)',
			),
		),
		
		'module_links' => array(
			'label' => 'produkty firmy',
			'btn' => 'Zobacz produkty firmy',
		),
	
		'see_all_btn' => 'Zobacz pozostałe produkty...',
		
		'permissions' => array(
			'admin' => array(
				'index' => 'Zezwól na przeglądanie produktów',
				'add' => 'Zezwól na dodawanie produktów',
				'edit' => 'Zezwól na edycję produktów',
				'delete' => 'Zezwól na usuwanie produktów',
				'approve' => 'Zezwól na akceptowanie produktów',
			),
		),
	),
	
	'site_products/home' => 'produkty',
	'site_products/frontend/products/add' => 'produkty/dodaj',
	'site_products/frontend/products/pre_add' => 'produkty/przed-dodaniem',
	'site_products/frontend/products/search' => 'produkty/wyszukiwarka',
	'site_products/frontend/products/advanced_search' => 'produkty/wyszukiwarka-zaawansowana',
	'site_products/frontend/products/category' => 'produkty/kategoria/<category_id>/<title>',
	'site_products/frontend/products/show' => 'produkt(/<category_name>)/<product_id>/<title>',
	'site_products/frontend/products/promote' => 'produkt/promowanie/<product_id>',
	'site_products/frontend/products/index' => 'wszystkie-produkty',
	'site_products/frontend/products/promoted' => 'produkty-promowane',
	'site_products/frontend/products/show_by_user' => 'produkty-uzytkownika/<id>',
	'site_products/frontend/products/show_by_company' => 'produkty-firmy/<company_id>',
	'site_products/frontend/products/send' => 'produkty/wyslij/<id>',
	'site_products/frontend/products/print' => 'produkty/drukuj/<id>',
	'site_products/frontend/products/report' => 'produkty/zglos-naruszenie/<id>',
	'site_products/frontend/products/order' => 'produkty/zamowienie/<id>',
	'site_products/profile/products/my' => 'profil/moje-produkty',
	'site_products/profile/closet' => 'profil/produkty/schowek',
	'site_products/profile/products/delete_from_closet' => 'profil/produkty/usun-ze-schowka/<id>',
	'site_products/profile/products/add_to_closet' => 'profil/produkty/dodaj-do-schowka/<id>',
	'site_products/profile/products/edit' => 'profil/edytuj-produkt/<id>',
	'site_products/profile/products/renew' => 'profil/odnow-produkt/<id>',
	'site_products/profile/products/delete' => 'profil/usun-produkt/<id>',
	'site_products/profile/products/statistics' => 'profil/statystyki-produkty/<id>',
	'site_products/profile/products/delete_image' => 'profil/produkt/<product_id>/usun-zdjecie/<image_id>',
	'site_products/frontend/products/dig_up' => 'produkty/podbijanie/<id>',
	'site_notifier/notifier/products' => 'produkty/powiadamiacz',
	'site_products/frontend/comments/add' => 'produkty/dodaj-komentarz/<product_id>(/<parent_comment_id>)',
	'site_products/frontend/comments/vote' => 'produkty/komentarz/<comment_id>',
	'site_products/frontend/comments/report' => 'produkty/komentarz/<comment_id>/zglos',
	'site_products/frontend/products/tag' => 'produkty/tag/<tag>',
	'site_catalog/company/products' => array(
		'site' => 'firma/<subdomain>/produkty',
		'subdomain' => 'produkty',
	),
	'site_catalog/frontend/catalog/products' => 'firma/<company_id>,<title>/produkty',
);