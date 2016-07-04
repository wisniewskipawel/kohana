<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'offers' => array(
		'title' => 'Coupons',
		'module' => 'Coupons Module',
		
		'layout' => array(
			'add_btn' => 'POST A <strong>DEAL</strong>',
			'counter' => array(
				'one' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>DEAL<strong> NEAR YOU</span><br>Save Big on Gardening, Renovation, Fitness, Beauty and much more!',
				'few' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>DEALS<strong> NEAR YOU</span><br>Save Big on Gardening, Renovation, Fitness, Beauty and much more!',
				'other' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>DEALS<strong> NEAR YOU</span><br>Save Big on Gardening, Renovation, Fitness, Beauty and much more!',
			),
		),
		
		'images' => array(
			'error' => array(
				'max' => 'You can upload up to :nb images',
			),
		),
		
		'filename' => 'coupon:nb',
		
		'which' => array(
			'label' => 'View',
			'all' => 'All coupons',
			'standard' => 'Basic Coupons',
			'promoted' => 'Featured Coupons',
			'not_active' => 'Not active Deals',
			'active' => 'Active Deals',
			'not_approved' => 'Pending Deals',
		),
		
		'list' => array(
			'title_discount' => '<strike>:price_old</strike> <span style="font-size: 22px; color:#F7941D"><strong><b>:price</b></strong>',
			'offer_availability' => 'Expires',
			'discount' => ':discount % off', 
			'download_limit' => 'Coupons left',
			'availability' => 'Days left',
			'coupon_inactive' => 'not active',
			'no_results' => 'No Coupons found!',
		),
		
		'forms' => array(
			'availability' => 'Days',
			'category_id' => 'Category',
			'company_id' => 'Pro', 
			'offer_title' => 'Title',
			'offer_content' => 'Description', 
			'offer_price' => 'Sale Price (:currency)',
			'offer_price_proc' => 'Discount (%)',
			'offer_price_disc' => 'Discount (:currency)',
			'offer_price_old' => 'Regular Price (:currency)',
			'offer_person_type' => 'Individual / Pro',
			'offer_person' => 'Name',
			'offer_company_nip' => 'VAT',
			'discount' => 'Discount (%)',
			'discount_text' => 'Offer Price :price_new :currency, you save :discount :currency (:discount_proc%)',
			'download_limit' => 'Quantity', 
			'limit_per_user' => 'Limit per person',
			'offer_www' => 'Website', 
			'offer_youtube' => 'YouTube', 
			'offer_availability' => 'Expiries',
			'offer_distinction' => 'Distinction',
			'offer_promotion_availability' => 'Featured until', 
			'image' => 'Image',
			'coupon_expiration' => 'Validity',
			'coupon_expiration_info' => 'No earlier than expiry date',
			
			'person_types' => array(
				'person'	=> 'Individual',
				'company'	=> 'Pro',
			),
			
			'categories' => array(
				'category_name' => 'Nazwa',
				'category_meta_description' => 'META description', 
				'category_meta_keywords' => 'META keywords', 
				'category_meta_robots' => 'META robots', 
				'category_meta_revisit_after' => 'META revisit after', 
				'category_meta_title' => 'META title',
				'category_text' => 'Tekst wyświetlany na dole kategorii', 
				'category_age_confirm' => 'Wymagać potwierdzenie wieku?',
				'image' => 'Obrazek kategorii',
				'image_info' => 'dozwolone typy plików: *.png, *.jpg, *.gif,
					wymiary: 100x100px (lub zostanie automatycznie przeskalowany)',
				'icon' => 'Ikonka kategorii',
				'delete_icon' => 'usuń',
			),
			
			'settings' => array(
				'header_tab_title' => 'Nazwa zakładki w menu głównym',
				'provinces_enabled' => 'Włączyć województwa?',
				'confirm_required' => 'Potwierdzenia ofert dla użytkowników niezarejestrowanych włączone?',
				'confirmation_email' => 'Wysyłać powiadomienie do administratorów o akceptację oferty?',
				'promotion_time' => 'Liczba dni promowania oferty',
				'email_view_disabled' => 'Wyłączyć pokazywanie adresu email na podstronie oferty?',
				'index_box_limit' => 'Ilość ofert na stronie głównej modułu',
				'availability_max_days' => 'Maksymalna długość wyświetlania oferty (dni)',
			),
			
			'advanced_search' => array(
				'phrase' => 'Keyword', 
				'where' => 'Search in', 
				'where_values' => array(
					'title_and_description'	=> 'title and description',
					'title'					=> 'title',
					'description'			=> 'description',
				),
				'category_all' => 'all',
				'category' => 'Category',
				'price_from' => 'Price from', 
				'price_to' => 'Price to', 
				
			),
			
			'send' => array(
				'email' => 'Friend&rsquo;s email',
			),
			
			'sendcoupon' => array(
				'email' => 'Email',
				'amount' => 'Quantity',
			),
			
			'validator' => array(
				'amount' => array(
					'user_limit' => 'You can download up to :nb coupons',
					'error' => 'Invalid value!',
				),
				'offer' => array(
					'price' => array(
						'error' => 'Please enter in a value less than a regular price!',
						'invalid' => 'Invalid value!',
					),
				),
			),
		),
		
		'sort' => array(
			'closet' => 'Kolejność w schowku',
			'popular' => 'Popularność',
		),
		
		'distinctions' => array(
			Model_Offer::DISTINCTION_PREMIUM_PLUS => 'Top Deal',
			Model_Offer::DISTINCTION_NONE => 'none',
		),
		
		'payments' => array(
			'offer_add' => array(
				'title'			=> 'Post a Deal',
				'description'	=> 'Posting a Deal :offer_title',
			),
			
			'offer_promote' => array(
				'title'			=> 'Upgrade Deal',
				'description'	=> 'Upgrading Deal :offer_title (:distinction)',
			),
		),
		
		'company' => array(
			'title' => 'Offers',
			'see_all_btn' => 'Check the other Pro offers...',
		),
		
		'index' => array(
			'title' => 'All coupons',
			'all' => 'All',
			'today_ending' => 'Ending today',
		),
		
		'module_links' => array(
			'label' => 'special offers',
			'btn' => 'Pro special offers',
		),
		
		'notifier' => array(
			'title' => 'Create an alert for this search',
			'success' => 'Your search alert has been saved!',
		),
		
		'report' => array(
			'title' => 'Report Deal',
			'success' => 'Deal has been reported!',
		),
		
		'send' => array(
			'title' => 'Email this Deal to a friend',
			'success' => 'Deal has been sent!',
		),
		
		'promote' => array(
			'title' => 'Promoting your Deal with listing upgrades',
			'success' => 'Deal has been featured!',
			'points' => 'Current points: :promo',
			'no_promotion' => 'Cancel',
			'promotions' => array(
				Model_Offer::DISTINCTION_PREMIUM_PLUS => array(
					'title' => 'Upgrade to TOP DEAL',
					'description' => '<strong>TOP DEAL</strong> appears framed at the top of all listings pages and on the home page.',
					'company_free' => 'Free upgrade with Premium Plus',
				),
			),
		),
		
		'category' => array(
			'title' => 'All <strong>Coupons</strong> in :category_name',
		),
		
		
		'pre_add' => array(
			'add_btn' => 'Post a Deal without registration',
			),

		'add' => array(
			'title' => 'Post a Deal',
			'btn' => 'Post a Deal',
			'success' => array(
				NULL => 'Deal has been posted!',
				'moderate' => 'Deal has been posted! Deals posted without registration appear after approval by admin.',
				'payment' => 'Deal has been posted! Choose an upgrade to make a Deal active.',
			),
			'steps' => array(
				'logged' => 'Logged in',
				'not_logged' => 'Unregistered',
				'company' => 'Pro',
			),
		),
		
		'show_by_user' => array(
			'title' => 'Deals by :user_name',
			'btn' => 'See more Great Deals this bidder',
		),
		
		'show_by_company' => array(
			'title' => 'Coupons from :company_name',
		),
		
		'show' => array(
			'title' => 'Coupon',
			'download_coupon_btn' => 'Get <strong>Coupon</strong>',
			'discount_coupon' => '<strong>Coupon</strong>',
			'new_price' => array(
				'label' => 'Now',
				'annotation' => ':price less',
			),
			'old_price' => 'Value',
			'discount' => 'You save',
			'expiration_date' => array(
				'label' => 'Time left',
				'days' => array(
					'one' => 'Day',
					'few' => 'Days',
					'other' => 'Days',
				),
				'hours' => 'Hours',
				'minutes' => 'Minutes',
				'seconds' => 'Seconds',
			),
			'limit' => '<strong>:count</strong> out of <b>:limit</b> coupons sent',
			'availability' => array(
				'label' => 'The Deal',
				'active' => 'is <strong>on</strong>!',
				'inactive' => '<strong>expired</strong>!',
			),
			'offer_person_type' => array(
				'person' => 'Bidder',
				'company' => 'Pro details',
			),
			'offer_content' => 'Description',
			'coupon_code' => 'Coupon code',
			'coupon_dates' => 'Valid: <strong>:from</strong> to: <strong>:to</strong>',
		),
		
		'send_coupon' => array(
			'title' => 'Get Coupon',
			'success' => array(
				'one' => 'Coupon has been sent!',
				'few' => 'Coupons have been sent!',
				'many' => 'Coupons have been sent!',
			),
			'error' => array(
				'user_limit' => 'Your download limit has been exceeded!',
			),
		),
		
		'contact' => array(
			'title' => 'Contact',
			'success' => 'Message has been sent!'
		),
		
		'advanced_search' => array(
			'title' => 'Advanced search',
			'results' => 'Search results',
			'no_results' => 'No deals found!',
		),
		
		'search' => array(
			'title' => 'Browse Deals',
			'results' => 'Search results',
			'no_results' => 'No Deals found!',
			'phrase' => array(
				'placeholder' => 'Search Deal...',
				'error' => 'Search by keyword!',
			),
		),
		
		'overlay' => array(
			'notifier' => array(
				'title' => '&star; Create an alert for this search',
			),
		),
		
		'rss' => array(
			'index' => array(
				'title' => 'Recently posted',
				'description' => 'Recently posted Deals on :site_name',
			),
			'category' => array(
				'title' => 'Deals in :category',
				'description' => 'Recently posted Deals in :category on :site_name',
			),
		),
		
		'profile' => array(
		
			'downloaded_coupons' => 'downloaded',
			
			'promotions_box' => array(
				'offer_points' => 'Free Top Deals with Premium Plus: :nb',
			),
			
			'stats' => array(
				'count_offers' => 'Posted Deals: <strong>:nb</strong>',
				'count_active_offers' => array(
					'label' => 'Active Deals: <strong>:nb</strong> :link',
					'link' => 'view',
				),
			),
			
			'my' => array(
				'title' => 'My Deals',
			),
			
			'delete' => array(
				'success' => 'Deal has been removed!',
			),
			
			'statistics' => array(
				'title' => 'Deal Statistics',
				'offer_visits' => 'Views',
			),
			
			'closet' => array(
				'title' => 'Saved Deals',
				'tab' => 'Deals (:nb)',
				'add' => array(
					'success' => 'This Deal has been added to your watchlist!',
				),
				'delete' => array(
					'success' => 'This Deal has been removed from your watchlist!',
				),
			),
			
			'edit' => array(
				'title' => 'Edit Deal',
				'success' => 'Deal has been updated!',
			),
			
			'coupons' => array(
				'title' => 'Downloaded coupons',
				'no_results' => 'No results!',
				'table' => array(
					'token' => 'Code',
					'email' => 'Email',
					'date' => 'Date',
				),
			),
			
			'renew' => array(
				'title' => 'Renew',
				'success' => 'Deal has been renewed!',
				'error_days_left' => array(
					'one' => 'You can renew this Deal tomorrow.',
					'other' => 'You can renew this Job in :days_left days.',
				),
			),
		),
		
		'admin' => array(
			'count_offers' => 'Deals',
			
			'table' => array(
				'user' => 'Użytkownik',
				'promotion' => 'Promowanie',
				'promotion_yes' => 'TAK',
				'promotion_no' => 'nie',
				'approve' => 'potwierdź',
				'renew' => 'przedłuż',
			),
			
			'index' => array(
				'menu' => 'Przeglądaj oferty',
			),
				
			'add' => array(
				'title' => 'Dodawanie oferty',
				'menu' => 'Dodaj ofertę',
				'success' => 'Oferta została dodana!',
			),

			'edit' => array(
				'title' => 'Edycja oferty',
				'success' => 'Zmiany w ofercie zostały zapisane!',
			),

			'delete' => array(
				'title' => 'Usuwanie oferty',
				'success' => array(
					'one' => 'Oferta została usunięta!',
					'many' => 'Oferty zostały usunięte!',
				),
			),

			'approve' => array(
				'success' => array(
					'one' => 'Oferta została zaakceptowana!',
					'many' => 'Oferty zostały zaakceptowane!',
				),
			),
			
			'renew' => array(
				'title' => 'Przedłużanie oferty',
				'success' => 'Oferta została przedłużona!',
			),
			
			'promote' => array(
				'title' => 'Promowanie oferty',
				'success' => 'Oferta została wypromowana!',
			),
			
			'categories' => array(
				'index' => array(
					'title' => 'Kategorie',
					'menu' => 'Przeglądaj kategorie',
				),
				
				'add' => array(
					'title' => 'Dodawanie kategorii',
					'menu' => 'Dodaj kategorię',
					'success' => 'Kategoria została dodana!',
				),
				
				'edit' => array(
					'title' => 'Edytuj kategorię',
					'success' => 'Zmiany w kategorii zostały zapisane!',
				),
				
				'delete' => array(
					'success' => 'Kategoria została usunięta!',
				),

				'delete_icon' => array(
					'success' => 'Ikonka została usunięta!',
				),
			),
				
			'settings' => array(
				'title' => 'Ustawienia ofert',
				'success' => 'Ustawienia zostały zapisane!',
			),
			
			'payments' => array(
				'title' => 'Płatności ofert',
				'success' => 'Zmiany zostały zapisane!',
				
				'enabled_values' => array(
					'disabled'	=> 'wyłączona',
					'all'		=> 'włączona dla wszystkich',
					'not_registered'	=> 'włączona dla niezarejestrowanych',
				),
				
				'offer_add' => array(
					'title' => 'Płatność za Dodawanie oferty',
				),
			),
			
			'users' => array(
				'offers_count' => 'Ilość ofert firm',
				'action_links' => array(
					'title' => 'pokaż oferty',
				),
				'promotions' => array(
					'offer_points' => 'Wpisz ilość punktów promocyjnych do promowania ofert (1 punkt = 1 darmowa TOP oferta)',
					'info' => 'Aktualna ilość punktów promocyjnych użytkownika: :nb',
				),
			),
		),
		
		'boxes' => array(
			'categories' => array(
				'title' => 'Choose Category',
				'all' => 'All',
			),
			
			'home' => array(
				'title' => 'Coupons',
				'promoted' => 'Top Deals',
				'recommended' => 'Recently posted',
			),
			
			'promoted' => array(
				'title' => 'Top Deals',
			),
			
			'modules' => array(
				'title' => 'Top Deals',
				'add_btn' => 'Post a Deal',
			),
		),
		
		'email' => array(
			'expiring' => array(
				'prolong' => 'renew',
				'add_btn' => 'post a deal',
			),
			
			'report' => array(
				'subject' => 'Violation of the rules on this website',
			),
			
			'notifier' => array(
				'unsubscribe' => 'Unsubscribe',
			),
		),
		
		'permissions' => array(
			'admin' => array(
				'index' => 'Zezwól na przeglądanie ofert',
				'add' => 'Zezwól na dodawanie ofert',
				'edit' => 'Zezwól na edycję ofert',
				'delete' => 'Zezwól na usuwanie ofert',
				'approve' => 'Zezwól na akceptowanie ofert',
			),
		),
	),
	
	'site_offers/home' => 'deals',
	'site_offers/profile/offers/promo_packets' => 'my-account/deals/promo-packets',
	'site_offers/frontend/offers/add' => 'deals/post',
	'site_offers/frontend/offers/age_confirm' => 'deals/age-confirm',
	'site_offers/frontend/offers/pre_add' => 'deals/pre-add',
	'site_offers/frontend/offers/send_coupon' => 'deals/download/<id>',
	'site_offers/frontend/offers/contact' => 'deals/contact/<id>',
	'site_offers/profile/offers/coupons' => 'my-account/deals/coupons/<id>',
	'site_offers/profile/offers/my' => 'my-account/deals',
	'site_offers/profile/closet' => 'my-account/deals/watchlist',
	'site_offers/profile/offers/delete_from_closet' => 'my-account/deals/watchlist/remove<id>',
	'site_offers/frontend/offers/search' => 'deals/search',
	'site_offers/frontend/offers/advanced_search' => 'deals/advanced-search',
	'site_offers/frontend/offers/category' => 'deals/category/<category_id>/<title>',
	'site_offers/frontend/offers/show' => 'deals/<offer_id>/<title>',
	'site_offers/frontend/offers/promote' => 'deals/upgrade/<offer_id>',
	'site_offers/frontend/offers/index' => 'deals/',
	'site_offers/frontend/offers/province' => 'deals/county/<id>',
	'site_offers/profile/offers/add_to_closet' => 'my-account/deals/save/<id>',
	'site_offers/frontend/offers/send' => 'deals/send/<id>',
	'site_offers/frontend/offers/show_by_user' => 'deals/<id>',
	'site_offers/frontend/offers/show_by_company' => 'deals/<company_id>',
	'site_offers/profile/offers/edit' => 'my-account/deals/edit/<id>',
	'site_offers/profile/offers/renew' => 'my-account/deals/renew/<id>',
	'site_offers/profile/offers/delete' => 'my-account/deals/remove/<id>',
	'site_offers/profile/offers/statistics' => 'my-account/deals/statistics/<id>',
	'site_offers/frontend/offers/report' => 'deals/report/<id>',
	'site_offers/profile/offers/delete_image' => 'my-account/deals/image/remove<image_id>/<offer_id>',
	'site_notifier/notifier/offers' => 'deals/alert',
);