<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

return array(
	'catalog' => array(
		'title' => 'Find a Pro',
		'module' => 'Find a Pro Module',
		'company' => 'Pro',
		
		'header' => array(
			'counter' => array(
				'one' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>PRO</strong> IN ANY CATEGORY TO GET YOUR JOB DONE</span><br>You can post a request on PROFFER and let the Pros come to you!',
				'few' => '<span style="font-size:36px; font-family:nexa bold">FIND & HIRE <strong>PRO</strong> FROM :counter ONLINE</span><br>You can post a request on PROFFER and let the Pros come to you!',
				'other' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>PRO</strong> TO GET YOUR JOB DONE</span><br>You can post a request on PROFFER and let the Pros come to you!',
			),
			'add_btn' => 'BECOME A <strong>PRO</strong>',
		),
		
		'module_links' => array(
			'label' => 'Pro Online',
			'btn' => 'Pro Profile',
		),
		
		'company_name' => 'Pro / Company name',
		'company_address' => 'Street address',
		'company_postal_code' => 'Eircode',
		'company_city' => 'Town / City',
		'company_map' => 'Specify the exact location on the map', 
		'company_telephone' => 'Phone number',
		'company_email' => 'Email',
		'link' => 'Website', 
		'company_description' => 'Description', 
		'company_products' => 'Products', 
		'company_keywords' => 'Keywords', 
		'company_keywords_label_help' => '(separated by commas)', 
		'slug' => 'Site name', 
		'promotion_type' => 'Promotion Type', 
		'company_is_promoted' => 'Featured?',
		'company_promotion_availability' => 'Promotion availability', 
		'logo' => 'Logo',
		'company_hours' => 'Availability',
		
		'company_logo' => array(
			'title' => 'Logo',
			'edit' => 'Edit logo',
			'change' => 'Change logo',
		),
		
		'trade' => 'Trade',
		
		'with_discount' => 'Apply the discount :discount%',
		
		'category_nb' => 'Category :nb',
		
		'companies_count' => 'The number of Pros',
		'companies_not_approved_count' => 'Not approved',
		
		'phrase' => 'Keyword',
		'where' => 'Search in',
		'where_select' => array(
			'name_and_description'	=> 'name and description',
			'name'				=> 'name',
			'description'			=> 'description',
		),
		
		'payments' => array(
			'company_add' => array(
				'title' => 'Basic',
				'description' => 'Become a Pro: :company_name with Basic Plan',
				
				'disabled' => 'disabled',
				'enabled_all' => 'enabled for all',
				'enabled_not_registered' => 'enabled for registered',
				'enabled' => array(
					'label' => 'Payment for :title',
				),
			),
			
			'company_promote' => array(
				'title'			=> 'Become a featured Pro for 12 months',
				'description'	=> ':company_name featured (:promotion_type)',
			),
		),
		
		'filters' => array(
			'all' => 'all',
			
			'company_id' => 'Search with Pro ID',
			
			'promoted' => array(
				'title' => 'Featured',
				'now' => 'now',
				'past' => 'in the past',
				'no' => 'never',
			),
		),
		
		'forms' => array(
			'company_send' => array(
				'email' => 'Email',
			),
			
			'company_hours' => array(
				'open' => array(
					'closed', 'open',
				),
			),
			
			'validator' => array(
				'company_slug' => array(
					'invalid_chars' => 'The string contains non-alphanumeric characters!',
					'duplicate' => 'This name is already taken!',
				),
				
				'company_hours' => array(
					'error' => 'Invalid time / date format!',
				),
			),
		),
		
		'admin' => array(
			
			'users' => array(
				'companies_count' => 'The number of Pros',
				'btn' => 'show pros',
				
				'promotions' => array(
					'no_sms' => 'No promotion payment by text!',
					'info' => 'Specify the discount for Premium Plus upgrade (applies once). 
						Pro will be informed about the offered discount.',
					'catalog_discount' => 'Discount offered',
					'user_rabat' => 'Current discount: :nb %',
				),
			),
			
			'companies' => array(
				'title' => 'Pros',
				'browse' => 'Browse Pros',
				
				'table' => array(
					'company_name' => 'Pro / Company name',
					'categories' => 'Categories',
					'promotion' => 'Feature',
					'promotion_expired' => 'Feature expired',
					'promotion_yes' => 'YES',
					'promotion_no' => 'no',
					'promotion_to' => 'to',
					'approved' => 'Approved?',
					'approved_yes' => 'yes',
					'approved_no' => 'NO',
					'approve' => 'approve',
					'user' => 'User',
					
				),
				
				'add' => array(
					'title' => 'Become a Pro',
					'btn' => 'Become a Pro',
					'success' => 'Pro has been added!',
				),
				
				'approve' => array(
					'success' => array(
						'one' => 'Pro has been approved!',
						'many' => 'Pros have been approved!',
					),
				),
				
				'edit' => array(
					'title' => 'Edit',
					'success' => 'Profile successfully updated!',
					'logo' => array(
						'success' => 'Logo successfully updated!',
					),
				),
				
				'delete' => array(
					'title' => 'Remove Pro',
					'success' => array(
						'one' => 'Pro has been removed!',
						'many' => 'Pros have been removed!',
					),
				),
			),
		
			'categories' => array(
				'title' => 'Categories',
				'browse' => 'Browse Categories',
				
				'add' => array(
					'title' => 'Adding category',
					'btn' => 'Add Category',
					'success' => 'Category has been added!',
				),
				'edit' => array(
					'title' => 'Editing category',
					'success' => 'Category successfully updated!',
				),

				'ordering' => array(
					'success' => 'Order has been changed!',
				),

				'delete' => array(
					'success' =>  array(
						'one' => 'Category has been removed!',
						'many' => 'Categories have been removed!',
					),
				),

				'delete_icon' => array(
					'success' => 'Icon has been removed!',
				),
				
				'show_companies_btn' => 'show pros',
				'subcategory_add_btn' => 'add subcategory',
			),
			
			'reviews' => array(
				'title' => 'Pro reviews',
				
				'show' => array(
					'title' => 'Review',
				),
				
				'change_status' => array(
					'success' => 'Status successfully updated!',
				),
				
				'edit' => array(
					'title' => 'Edit review',
					'success' => 'Review successfully updated!',
				),
				
				'delete' => array(
					'success' => array(
						'one' => 'Review has been removed!',
						'many' => 'Reviews have been removed!',
					),
				),
				
				'approve' => array(
					'select_many' => 'Accept selected',
					'success' => array(
						'one' => 'Review has been accepted!',
						'many' => 'Reviews have been accepted!',
					),
				),
			),
			
			'payments' => array(
				'title' => 'Płatności katalogu firm',
				'success' => 'Zmiany zostały zapisane!',
			),
			
			'settings' => array(
				'title' => 'Ustawienia katalogu firm',
				'success' => 'Zmiany zostały zapisane!',
				
				'general_tab' => 'Ogólne',
				'header_tab_title' => 'Nazwa zakładki w menu głównym',
				'map' => 'Włączyć województwa?',
				'email_view_disabled' => 'Wyłączyć pokazywanie adresu email na podstronie oferty?',
				'promotion_months' => 'Okres promowania firmy dla: :title (w miesiącach)',

				'promotion_types' => array(
					'label' => 'Ustawienia typów wpisów',
					'enabled' => 'Włącz typ: :title',
				),
				
				'reviews_tab' => 'Opinie o firmach',
				'reviews_enabled' => 'Włącz opinie o firmach',
				'reviews_moderate_disabled' => 'Wyłącz moderację opinii (opinie będą pojawiały się od razu po dodaniu - bez konieczności akceptacji w PA)',
			),
			
			'forms' => array(
				'category' => array(
					'add' => array(
						'general_tab' => 'General',
						'seo' => 'SEO',
					),
					'icon' => 'Category icon',
					'delete_icon' => 'delete',
				),
				
				'company' => array(
					'add' => array(
						'category' => 'Category :nb',
					),
				),
			),
			
		),
		
		'reviews' => array(
			'title' => 'Reviews',
			
			'email' => 'Your email',
			'rating' => 'Rate',
			'comment_body' => 'Comment', 
			'comment_author' => 'Name', 
			
			'add' => array(
				'title' => 'Write review',
				'btn' => 'Write review',
				'success' => array(
					NULL => 'Your review has been posted!',
					'moderate' => 'Your review has been saved and will appear on Pro profile after admin confirmation.',
				),
			),
		
			'status' => array(
				'accepted' => 'Accepted',
				'accept' => 'Accept',
				'not_accepted' => 'Not accepted',
			),
			
			'show' => array(
				'average' => 'Overall rate',
				'count_reviews' => 'Reviews',
				'comment_author' => 'Review posted by',
			),
			
			'no_results' => 'No reviews yet.',
		),
		
		'companies' => array(
			
			'show' => array(
				'title' => 'Pro details',
				'btn' => array(
					'premium' => 'View Pro',
					'premium_plus' => 'View Pro',
				),
				'date_added' => 'created',
				'visits' => 'visits',
				'reviews' => 'Reviews (:nb)',
			),
			
			'list' => array(
				'promotion_days_left' => 'Featured: :days left',
				'prolong_promote' => 'Upgrade',
				'promote' => 'Upgrade',
				'delete' => 'Remove',
				'delete_confirm' => 'Are you sure you want to remove this Pro?',
				'no_results' => 'No Pros found!',
				'map' => array(
					'show' => 'Show on map',
					'hide' => 'Hide map',
				),
			),
			
			'add' => array(
				'title' => 'Become a Pro',
				'success' => array(
					NULL => 'Pro has been added!',
					'moderate' => 'Your profile has been saved and will appear in Pro directory after admin approval.',
				),
				'error' => 'An error occured, please try again later.',
			),
			
			'send' => array(
				'title' => 'Email this Pro to a friend',
				'success' => 'Message has been sent successfully!',
			),
			
			'promoted' => array(
				'title' => 'Featured Pros',
				'catalog.boxes.carousel.more' => 'More &raquo',
			),
			
			'promotion' => array(
				'title' => 'Upgrade a Pro',
				
				'types' => array(
					Model_Catalog_Company::PROMOTION_TYPE_BASIC => 'Basic',
					Model_Catalog_Company::PROMOTION_TYPE_PREMIUM => 'Premium',
					Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS => 'Premium Plus',
				),
			),
			
			'promote' => array(
				'success' => 'Pro has been featured!',
			),
			
			'contact' => array(
				'info' => 'Send message',
				'success' => 'Message successfully sent!',
			),
			
			'approve' => array(
				'success' => 'Feature has been successfully activated!',
			),
			
			'index' => array(
				'title' => 'Pros',
			),
			
			'category' => array(
				'from_city' => 'From <span style="color:#0e8d94">:city</span>',
				'title' => 'All in <span style="color:#0e8d94">:category_name</span>',
			),
			
			'search' => array(
				'title' => 'Search Pros',
				'results' => 'Search results',
				'phrase' => array(
					'placeholder' => 'Search Pro...',
					'error' => 'Please try modifying your search to get more results.',
				),
			),
			
			'advanced_search' => array(
				'title' => 'Advanced search',
				'results' => 'Search results',
			),
			
			'products' => array(
				'title' => 'Products',
			),
		),
		
		'profile' => array(
			'closet' => array(
				'title' => 'Saved Pros',
				'tab' => 'Pros (:nb)',
				'delete' => array(
					'success' => 'This Pro has been removed from your watchlist!',
					'btn' => 'Remove from my watchlist',
				),
				'add' => array(
					'success' => 'This Pro has been added to your watchlist!',
				),
			) ,
			
			'my' => array(
				'title' => 'My Pros',
			),
			
			'edit' => array(
				'title' => 'Edit Pro',
				'success' => 'Pro has been updated!',
				'btn' => 'Submit',
			),
			
			'delete' => array(
				'success' => 'Pro has been removed!',
			),
			
			'promotions_box' => array(
				'info' => 'Current discount for Premium Plus upgrade: :nb%',
			),
			
			'stats' => array(
				'count_companies' => 'Posted Pros: <strong>:nb</strong>',
				'count_active_companies' => 'Active Pros: <strong>:nb</strong>',
			),
			
			'prolong_promote' => array(
				'title' => 'Upgrade',
			),
			
			'promote' => array(
				'title' => 'Upgrade a Pro',
			),
		),
		
		'rss' => array(
			'index' => array(
				'title' => 'Recently added Pros',
				'description' => 'Recently added Pros from :site_name',
			),
			'category' => array(
				'title' => 'Recently added Pros in :category',
				'description' => 'Recently added Pros in :category on :site_name',
			),
		),
		
		'subdomain' => array(
			'about' => array(
				'title' => 'About',
			),
			'gallery' => array(
				'title' => 'Gallery',
			),
			'contact' => array(
				'title' => 'Contact',
			),
			'reviews' => array(
				'title' => 'Reviews',
			),
			'contact_data' => array(
				'title' => 'Pro Details',
			),
		),

		'boxes' => array(
			'categories' => array(
				'title' => 'Select Category',
				'collapse' => 'Hide',
				'expand' => 'More &raquo',
			),
			
			'sidebar_promoted' => array(
				'title' => 'Featured',
				'all' => 'All',
			),
			
			'sidebar_recommended' => array(
				'title' => 'Featured',
			),
			
			'carousel' => array(
				'promoted' => 'Featured',
				'popular' => 'Popular',
				'last' => 'Latest',
			),
			
			'modules' => array(
				'title' => 'Pros',
				'add_btn' => 'Become a Pro',
			),
		),
		
		'permissions' => array(
			'admin' => array(
				'companies' => array(
					'index' => 'Zezwól na przeglądanie firm',
					'add' => 'Zezwól na dodawanie firm',
					'edit' => 'Zezwól na edycję firm',
					'delete' => 'Zezwól na usuwanie firm',
					'approve' => 'Zezwól na akceptowanie firm',
				),
			),
		),
		
	),
	
	'site_catalog/home' => 'pros',
	'site_catalog/frontend/catalog/pre_add' => 'pros/pre-add',
	'site_catalog/frontend/catalog/add_to_closet' => 'pros/watchlist/save/<id>',
	'site_catalog/frontend/catalog/closet/delete' => 'pros/watchlist/remove/<id>',
	'site_catalog/profile/closet' => 'my-account/pros/watchlist',
	'site_catalog/profile/catalog/renew' => 'my-account/pros/renew/<id>',
	'site_catalog/frontend/catalog/send' => 'pros/send/<id>',
	'site_catalog/frontend/catalog/print' => 'pros/print/<id>',
	'site_catalog/frontend/catalog/advanced_search' => 'pros/advanced-search',
	'site_catalog/profile/catalog/delete_image' => 'pros/remove-image/<image_id>/<company_id>',
	'site_catalog/frontend/catalog/search' => 'pros/search',
	'site_catalog/frontend/catalog/add' => 'pros/add',
	'site_catalog/frontend/catalog/add_basic' => 'pros/basic/add',
	'site_catalog/frontend/catalog/add_promoted' => 'pros/featured/add',
	'site_catalog/profile/catalog/my' => 'my-account/pros',
	'site_catalog/profile/catalog/promote' => 'my-account/pros/upgrade/<id>',
	'site_catalog/profile/catalog/prolong_promote' => 'my-account/pros/upgrade/renew/<id>',
	'site_catalog/profile/catalog/payment' => 'my-account/pros/payment',
	'site_catalog/profile/catalog/delete' => 'my-account/pros/remove/<id>',
	'site_catalog/frontend/catalog/show_category' => 'pros/category(/<category_id>(/<title>))',
	'site_catalog/frontend/catalog/show' => 'pro/<company_id>/<title>',
	'site_catalog/profile/catalog/edit_promoted' => 'my-account/pros/edit-featured/<id>',
	'site_catalog/profile/catalog/edit_basic' => 'my-account/pros/edit/<id>',
	'site_catalog/frontend/catalog/promoted' => 'pros/upgrade',
	'site_catalog/frontend/catalog/reviews/add' => 'pros/review/add/<company_id>',
	'site_catalog/company/show' => array(
		'site' => 'firma/<subdomain>',
	),
	'site_catalog/company/gallery' => array(
		'site' => 'pro/<subdomain>/gallery',
		'subdomain' => 'gallery',
	),
	'site_catalog/company/contact' => array(
		'site' => 'pro/<subdomain>/contact',
		'subdomain' => 'contact',
	),
	'site_catalog/company/reviews' => array(
		'site' => 'pro/<subdomain>/reviews',
		'subdomain' => 'reviews',
	),
	'site_catalog/company/reviews/add' => array(
		'site' => 'pro/<subdomain>/reviews/add',
		'subdomain' => 'reviews/add',
	),
	'site_catalog/company/offers' => array(
		'site' => 'pro/<subdomain>/deals',
		'subdomain' => 'deals',
	),
	'site_catalog/company/announcements' => array(
		'site' => 'pro/<subdomain>/ogloszenia',
		'subdomain' => 'ogloszenia',
	),
	'site_catalog/frontend/catalog/offers' => 'pro/<company_id>,<title>/deals',
	'site_catalog/frontend/catalog/announcements' => 'pro/<company_id>,<title>/ogloszenia',
);