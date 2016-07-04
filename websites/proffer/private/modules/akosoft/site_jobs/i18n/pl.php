<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

return array(
	'jobs.module.name' => 'Browse Jobs',
	'jobs.module' => 'Jobs Module',
	'jobs.job' => 'Job',
	'jobs.jobs_count' => 'The number of Jobs',
	
	'jobs.form.category_id' => 'Category',
	'jobs.form.title' => 'Title',
	'jobs.form.content' => 'Description', 
	'jobs.form.price' => 'Budget', 
	'jobs.form.person_type' => 'Type',
	'jobs.form.company_id' => 'Pro',
	'jobs.form.person' => 'Full name / Pro',
	'jobs.form.person.person' => 'Full name',
	'jobs.form.person.company' => 'Name',
	'jobs.form.province' => 'County',
	'jobs.form.county' => 'County',
	'jobs.form.city' => 'Town / City',
	'jobs.form.street' => 'Street address',
	'jobs.form.postal_code' => 'Eircode',
	'jobs.form.map' => 'Specify the exact location on the map',
	'jobs.form.telephone' => 'Phone number', 
	'jobs.form.email' => 'Email',
	'jobs.form.www' => 'Website', 
	'jobs.form.availability_span' => 'Duration',
	'jobs.form.promotions' => 'Displaying and features',
	'jobs.form.promotion' => 'Feature',
	'jobs.form.distinction' => 'Feature',
	'jobs.form.date_realization_limit' => 'Delivery time',
	'jobs.form.date_promotion_availability' => 'Featured',
	'jobs.form.date_availability' => 'Expires',
	'jobs.form.add' => 'POST A JOB',
	
	'jobs.availability_span.days' => array(
		'one' => ':nb day',
		'other' => ':nb days',
	),
	
	'jobs.admin.payments.title' => 'Płatności zleceń',
	'jobs.admin.payments.success' => 'Zmiany zostały zapisane!',
	
	'jobs.admin.add.title' => 'Post a Job',
	'jobs.admin.add.success' => 'Job has been posted!',
	
	//search advanced form
	'phrase' => 'Keyword',
	'where' => 'Search in',
	'jobs.forms.search.where.title_and_description'	 => 'title and description',
	'jobs.forms.search.where.title'					 => 'title',
	'jobs.forms.search.where.description'			 => 'description',
	'city' => 'Town / City',
	'price_from' => 'Price €',
	'price_to' => 'Price to',
	
	//report form
	'jobs.forms.report.btn' => 'Report',
	
	//send friend form
	'jobs.forms.send.email' => 'Friend&#146;s email',
	
	//send message form
	'jobs.forms.sendmessage.email' => 'Email',
	'jobs.forms.sendmessage.subject' => 'Title',
	'jobs.forms.sendmessage.message' => 'Details',
	'jobs.forms.sendmessage.message.placeholder' => 'Message...',
	'jobs.forms.sendmessage.info' => 'Send message',
	
	'jobs.admin.table.show' => 'show jobs',
	
	'jobs.admin.menu.add' => 'Dodaj zlecenie',
	'jobs.admin.menu.index' => 'Przeglądaj zlecenia',
	'jobs.admin.menu.categories.index' => 'Przeglądaj kategorie',
	'jobs.admin.menu.categories.add' => 'Dodaj kategorię',
	'jobs.admin.menu.fields.index' => 'Przeglądaj pola',
	'jobs.admin.menu.fields.add' => 'Dodaj pole dodatkowe',
	'jobs.admin.menu.settings.general' => 'Ustawienia ogólne',
	
	'jobs.admin.delete.title' => 'Usuwanie zlecenia',
	'jobs.admin.delete.success' => array(
		'one' => 'Zlecenie zostało usunięte!',
		'many' => 'Zlecenia zostały usunięte!',
	),
	
	'jobs.admin.approve.success' => array(
		'one' => 'Zlecenie zostało zaakceptowane!',
		'many' => 'Zlecenia zostały zaakceptowane!',
	),
	
	'jobs.admin.renew.title' => 'Przedłużanie zlecenia',
	'jobs.admin.renew.success' => 'Zlecenie zostało przedłużone!',
	
	'jobs.admin.edit.title' => 'Edycja zlecenia',
	'jobs.admin.edit.success' => 'Zlecenie zostało edytowane!',
	
	'jobs.admin.edit_attributes.title' => 'Edycja pól dodatkowych',
	'jobs.admin.edit_attributes.success' => 'Zmiany zostały zapisane!',
	
	'jobs.admin.promote.title' => 'Promowanie zlecenia',
	'jobs.admin.promote.success' => 'Zlecenie zostało wypromowane!',
	
	'jobs.admin.availabilities.title' => 'Okresy wyświetlania',
	'jobs.admin.availabilities.add.title' => 'Dodaj okres wyświetlania',
	'jobs.admin.availabilities.add.success' => 'Okres wyświetlania zlecenia został dodany!',
	'jobs.admin.availabilities.edit.title' => 'Edycja okresu',
	'jobs.admin.availabilities.edit.success' => 'Okres wyświetlania zlecenia został zmieniony!',
	'jobs.admin.availabilities.delete.success' => 'Okres wyświetlania zlecenia został usunięty!',
	'jobs.admin.availabilities.list.title' => 'Lista',
	
	'jobs.admin.categories.title' => 'Kategorie',
	'jobs.admin.categories.add.title' => 'Dodawanie kategorii',
	'jobs.admin.categories.add.success' => 'Kategoria została dodana!',
	'jobs.admin.categories.edit.title' => 'Edycja kategorii',
	'jobs.admin.categories.edit.success' => 'Kategoria została edytowana!',
	'jobs.admin.categories.delete.success' => 'Kategoria została usunięta!',
	'jobs.admin.categories.forms.category_text' => 'Tekst wyświetlany na dole kategorii',
	'jobs.admin.categories.add_subcategory' => 'dodaj podkategorię',
	'jobs.admin.categories.show_subcategories' => 'pokaż podkategorie',
	'jobs.admin.categories.show_fields' => 'pola dodatkowe',
	'jobs.admin.categories.delete.confirm' => 'Usunięcie kategorii spowoduje usunięcie jej podkategorii i wszystkich zleceń w tych kategoriach! Tej akcji nie można cofnąć!',
	'jobs.admin.categories.forms.image' => 'Ikonka kategorii',
	'jobs.admin.categories.forms.delete_image' => 'Usuń ikonkę',
	'jobs.admin.categories.delete_image.success' => 'Ikonka kategorii została usunięta!',
	
	//comments
	'jobs.admin.comments.title' => 'Komentarze',
	'jobs.admin.comments.menu.index' => 'Przeglądaj komentarze',
	'jobs.admin.comments.show.title' => 'Szczegóły komentarza',
	'jobs.admin.comments.edit.title' => 'Edycja komentarza',
	'jobs.admin.comments.edit.success' => 'Komentarz został zmieniony!',
	'jobs.admin.comments.delete.success' => array(
		'one' => 'Komentarz został usunięty!',
		'many' => 'Komentarze zostały usunięte!',
	),
	'jobs.admin.comments.show.title' => 'Szczegóły komentarza',
	'jobs.admin.comments.reply_to' => 'W odpowiedzi do komentarza',
	
	//replies
	'jobs.admin.menu.replies.index' => 'Przeglądaj zgłoszenia',
	'jobs.admin.replies.title' => 'Zgłoszenia',
	'jobs.admin.replies.show.title' => 'Szczegóły zgłoszenia',
	'jobs.admin.replies.edit.title' => 'Edycja zgłoszenia',
	'jobs.admin.replies.edit.success' => 'Zgłoszenie zostało zmienione!',
	'jobs.admin.replies.delete.success' => array(
		'one' => 'Zgłoszenie zostało usunięte!',
		'many' => 'Zgłoszenia zostały usunięte!',
	),
	'jobs.admin.replies.show.title' => 'Szczegóły zgłoszenia',
	
	//category fields
	'jobs.admin.fields.title' => 'Pola dodatkowe',
	'jobs.admin.fields.add.title' => 'Dodaj pole dodatkowe',
	'jobs.admin.fields.add.success' => 'Pole zostało dodane!',
	'jobs.admin.fields.edit.title' => 'Edytuj pole dodatkowe',
	'jobs.admin.fields.edit.success' => 'Pole zostało zmienione!',
	'jobs.admin.fields.delete.success' => 'Pole dodatkowe zostało usunięte!',	
	'jobs.admin.fields.category.title' => 'Pola dodatkowe dla kategorii: :category',
	'jobs.admin.fields.category.error' => array(
		NULL => 'Wystąpił błąd!',
		'id' => 'Nie można odnaleźć pola o wybranym ID!',
	),
	'jobs.admin.fields.category.success' => 'Pole dodatkowe zostało dodane!',
	'jobs.admin.fields.category.delete' => 'usuń z kategorii',
	'jobs.admin.fields.category.delete.success' => 'Pole dodatkowe zostało usunięte z kategorii!',
	'jobs.admin.fields.category.add.title' => 'Dodaj pole dodatkowe dla tej kategorii',
	'jobs.admin.fields.category.add.choose_field' => 'Wybierz pole',
	'jobs.admin.fields.forms.label' => 'Nazwa pola',
	'jobs.admin.fields.forms.name' => 'Identyfikator tekstowy pola',
	'jobs.admin.fields.forms.name.error' => array(
		'regex' => 'To pole zawiera niedozwolone znaki! Dozwolone są małe litery, cyfry oraz -_',
	),
	'jobs.admin.fields.forms.options.required' => 'Pole wymagane do wypełnienia/zaznaczenia', 
	'jobs.admin.fields.forms.type' => 'Typ pola',
	'jobs.admin.fields.forms.options.values' => 'Wpisz opcje do wyboru dla listy', 
	'jobs.admin.fields.forms.options.values.info' => 'Poszczególne opcje w osobnych liniach.', 
	
	'jobs.admin.fields.types.text' => 'Pole tekstowe',
	'jobs.admin.fields.types.select' => 'Lista',
	'jobs.admin.fields.types.checkbox' => 'Pole do zaznaczenia',
	
	'jobs.admin.settings.title' => 'Ustawienia zleceń',
	'jobs.admin.settings.success' => 'Ustawienia zostały zapisane!',
	'jobs.admin.settings.form.tab_general' => 'Ogólne',
	'jobs.admin.settings.form.header_tab_title' => 'Nazwa zakładki w menu głównym',
	'jobs.admin.settings.form.provinces_enabled' => 'Włącz województwa',
	'jobs.admin.settings.form.tab_promotions' => 'Promowanie',
	'jobs.admin.settings.form.promotion_time' => 'Ilość dni promowania zleceń',
	'jobs.admin.settings.form.promotion_text' => 'Opis promowania: :distinction',
	'jobs.admin.settings.form.show_email' => 'Wyświetlaj adres e-mail na stronie zlecenia',
	'jobs.admin.settings.form.tab_home' => 'Strona główna',
	'jobs.admin.settings.form.home_promoted_box_limit' => 'Ilość zleceń w boksie promowanych zleceń (strona główna modułu)',
	'jobs.admin.settings.form.home_recent_box_limit' => 'Ilość zleceń w boksie ostatnio dodanych zleceń (strona główna modułu)',
	'jobs.admin.settings.form.replies.show_contact_not_logged' => 'Wyświetlaj dane kontaktowe w zgłoszeniach do zleceń dla niezalogowanych użytkowników',
	
	'jobs.header.counter' => array(
		'one' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>JOB</strong> FOR YOUR SKILLS</span><br>Join PROFFER to become a Pro, submit free quotes and get hired today!',
		'few' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>JOBS</strong> FOR YOUR SKILLS</span><br>Join PROFFER to become a Pro, submit free quotes and get hired today!',
		'other' => '<span style="font-size:36px; font-family:nexa bold">SEARCH OVER :counter <strong>JOBS</strong> FOR YOUR SKILLS</span><br>Join PROFFER to become a Pro, submit free quotes and get hired today!',
	),
	'jobs.header.add_btn' => 'POST A <strong>JOB</strong>',
	
	'jobs.search_pk' => 'Search Job ID',
	
	'jobs.forms.validators.availability.error' => 'Możesz skrócić lub wyłączyć promowanie zlecenia',
	
	'jobs.expiring.registered.renew_btn' => 'renew',
	'jobs.expiring.not_registered.add_btn' => 'post a job',
	'jobs.expiring.not_registered.renew_btn' => 'renew',
	
	'jobs.approve.success' => 'Job has been posted!',
	
	'jobs.which' => 'Show',
	'jobs.which.all' => 'All Jobs',
	'jobs.which.standard' => 'Basic Jobs',
	'jobs.which.promoted' => 'Featured Jobs',
	'jobs.which.not_active' => 'Expired Jobs',
	'jobs.which.active' => 'Active Jobs',
	'jobs.which.not_approved' => 'Pending Jobs',
	
	'jobs.admin.title' => 'Title',
	'jobs.admin.details' => 'Description',
	'jobs.admin.promotion' => 'Feature',
	'jobs.admin.promotion.yes' => 'YES',
	'jobs.admin.promotion.no' => 'no',
	'jobs.admin.promotion.promote' => 'upgrade',
	'jobs.admin.promotion.promote_change' => 'change features',
	'jobs.admin.user' => 'Użytkownik',
	
	'site_jobs.payments.job_add.title' => 'Post a Job',
	'site_jobs.payments.job_add.description' => 'Post a Job :title',
	
	'site_jobs.payments.job_promote.title' => 'Upgrade a Job',
	'site_jobs.payments.job_promote.description' => 'Upgrade a Job :title (:distinction)',
	'jobs.promotion.premium' => 'Premium',
	'jobs.promotion.premium_plus' => 'Premium Plus',
	
	'jobs.promote.success' => 'Job has been featured!',
	
	'jobs.add.title' => 'Post a Request',
	'jobs.add.success' => 'Job has been posted!',
	'jobs.add.success_payment' => 'Job has been posted! Make a payment to make it alive.',
	'jobs.add.info' => '<div style="font-size: 22px"><b>Can&#146;t find what you&#146;re looking for?</b></div>Post a request for a service that you need.',
	
	'jobs.report.title' => 'Report',
	'jobs.report.email.subject' => 'Report this Job on :site',
	'jobs.report.success' => 'Job has been reported!',
	
	'jobs.category.title' => 'All in :category',
	
	'jobs.show_by_user.title' => '<div style="color:#0e8d94">:user_name</div>',
	
	'jobs.rss.last.title' => 'Recently posted',
	'jobs.rss.last.description' => 'Recently posted Jobs on :site_name',
	'jobs.rss.category.title' => 'All in :category',
	'jobs.rss.category.description' => 'Recently posted Jobs in :category on :site_name',
	
	'jobs.sendmessage.success' => 'Message has been sent!',
	
	'jobs.send.title' => 'Email this Job to a friend',
	'jobs.send.success' => 'Job has been sent!',
	
	'jobs.advanced_search.title' => 'Advanced search',
	'jobs.advanced_search.results' => 'Search results',
	'jobs.advanced_search.no_results' => 'No Jobs found!',
	
	'jobs.search.title' => 'Search Job',
	'jobs.search.phrase.placeholder' => 'Search Job...',
	'jobs.search.phrase.error' => 'Search by keyword!',
	'jobs.search.results' => 'Search results',
	
	// BOXES
	
	'jobs.boxes.categories.title' => 'Choose category',
	'jobs.boxes.more' => 'More',
	
	'jobs.boxes.home.promoted.title' => 'Featured Jobs',
	'jobs.boxes.home.recent.title' => 'Recently posted Jobs',
	
	'jobs.boxes.modules.title' => 'Jobs',
	'jobs.boxes.modules.add_btn' => 'Post a Job',
	
	// SHOW
	
	'jobs.show.price' => 'Budget',
	'jobs.show.price.not_set' => 'not specified',
	'jobs.show.date_added' => 'Posted',
	'jobs.show.date_availability' => 'Expires',
	'jobs.show.visits' => 'Views',
	'jobs.show.count_replies' => 'Offers',
	'jobs.show.details' => 'Job details',
	'jobs.show.content' => 'Description',
	'jobs.show.principal' => 'Pro seeker',
	'jobs.show.show_on_map' => 'Show on map',
	'jobs.show.archived.info' => 'This Job expired on :date.',
	'jobs.show.date_realization_limit' => 'Delivery time',
	'jobs.show.date_realization_limit.not_set' => 'not specified',
	
	//replies
	'jobs.replies.show.title' => 'Offers',
	'jobs.replies.lists.no_results' => 'No offers found. Be the first!',
	'jobs.replies.lists.price' => 'Price',
	'jobs.replies.lists.no_price' => 'negotiable',
	'jobs.replies.lists.price_unit.all' => 'total',
	'jobs.replies.lists.price_unit.hour' => 'per hour',
	'jobs.replies.lists.price_unit.item' => 'per piece',
	'jobs.replies.not_logged.info' => '<div style="font-size: 22px">You need to be <b><strong>logged in</strong></b> to be able to send offer.</div>'
	. 'Don&#146;t have an account yet? <a href=":register_url">Sign up for free</a>',
	'jobs.replies.forms.content' => 'Add description to your offer',
	'jobs.replies.forms.price' => 'Offer amount',
	'jobs.replies.forms.price_unit' => 'Price',
	'jobs.replies.price_units.all' => 'total',
	'jobs.replies.price_units.hour' => 'per hour',
	'jobs.replies.price_units.item' => 'per piece',
	'jobs.replies.add.title' => 'Send your offer',
	'jobs.replies.add.success' => 'Your offer has been submited!',
	
	//comments
	'jobs.comments.show.title' => 'Ask a question about this job',
	'jobs.comments.not_logged.info' => '<div style="font-size: 22px">You need to be <b><strong>logged in</strong></b> to be able to ask a question about this job.</div>'
	. 'Don&#146;t have an account yet? <a href=":register_url">Sign up for free</a>',
	'jobs.comments.title' => 'Questions',
	'jobs.comments.add_reply' => 'reply',
	'jobs.comments.forms.body' => 'Question',
	'jobs.comments.add.title' => 'Ask a question about this job',
	'jobs.comments.add.success' => 'Question has been submited!',
	
	'jobs.attributes' => 'More details',
	
	//contact
	'jobs.contact.title' => 'Contact',
	'jobs.contact.success' => 'Message has been sent!',
	
	// LISTS
	
	'jobs.list.no_results' => 'No Jobs found!',
	
	//notifier
	'jobs.notifier.title' => '&star; Create an alert for this search',
	'jobs.notifier.success' => 'Your search alert has been saved!',
	'jobs.notifier.email.unsubscribe' => 'Unsubscribe',
	
	// PROFILE
	
	'jobs.profile.promotions.info' => 'Current Jobs available with Premium Plus upgrade: :nb',
	'jobs.profile.stats.count_added' => 'Posted Jobs: <strong>:nb</strong>',
	'jobs.profile.stats.count_active' => 'Active Jobs:  <strong>:nb</strong> :link',
	'jobs.profile.stats.count_active.btn' => 'view',
	
	'jobs.profile.closet.title' => 'Saved Jobs',
	'jobs.profile.closet.add.success' => 'This Job has been added to your watchlist!',
	'jobs.profile.closet.delete.success' => 'This Job has been removed from your watchlist!',
	
	'jobs.profile.edit.title' => 'Edit Job',
	'jobs.profile.edit.success' => 'Job has been updated!',
	'jobs.profile.edit.attributes.success' => 'Job has been updated!',
	
	'jobs.profile.my.title' => 'My Jobs',
	'jobs.profile.my.list.days_left' => array(
		'one' => 'Active: :days_left day left',
		'other' => 'Active: :days_left days left',
	),
	'jobs.profile.my.list.inactive' => 'Expired',
	
	'jobs.profile.renew.title' => 'Renew',
	'jobs.profile.renew.success' => 'Job has been renewed!',
	'jobs.profile.renew.error_days_left' => array(
		'one' => 'You can renew this Job tomorrow.',
		'other' => 'You can renew this Job in :days_left days.',
	),
	
	'jobs.profile.statistics.title' => 'Job Statistics',
	
	'jobs.profile.delete.success' => 'Job has been removed!',
	
	'jobs.profile.promote.title' => 'Upgrade Job',
	
	'jobs.closet.tab' => 'Jobs (:nb)',
	
	// ADMIN
	
	// permissions
	
	'jobs.permissions.admin.index' => 'Zezwól na przeglądanie zleceń',
	'jobs.permissions.admin.add' => 'Zezwól na dodawanie zleceń',
	'jobs.permissions.admin.edit' => 'Zezwól na edycję zleceń',
	'jobs.permissions.admin.delete' => 'Zezwól na usuwanie zleceń',
	'jobs.permissions.admin.approve' => 'Zezwól na akceptowanie zleceń',
	
	
	// ROUTES
	
	'site_jobs/home' => 'jobs',
	'site_jobs/frontend/jobs/add' => 'jobs/post',
	'site_jobs/frontend/jobs/search' => 'jobs/search',
	'site_jobs/frontend/jobs/advanced_search' => 'jobs/advenced-search',
	'site_jobs/frontend/jobs/category' => 'jobs/category/<category_id>/<title>',
	'site_jobs/frontend/jobs/show' => 'jobs(/<category_name>)/<id>/<title>',
	'site_jobs/frontend/jobs/renew' => 'jobs/renew/<id>/<token>',
	'site_jobs/frontend/jobs/index' => 'jobs/all',
	'site_jobs/frontend/jobs/promoted' => 'jobs/featured',
	'site_jobs/frontend/jobs/show_by_user' => 'jobs/user/<user_id>',
	'site_jobs/frontend/jobs/send' => 'jobs/send/<id>',
	'site_jobs/frontend/jobs/print' => 'zlecenia/print/<id>',
	'site_jobs/frontend/jobs/contact' => 'jobs/contact/<id>',
	'site_jobs/frontend/jobs/report' => 'zlecenia/report/<id>',
	'site_jobs/frontend/comments/add' => 'jobs/comment/post/<job_id>(/<parent_comment_id>)',
	'site_jobs/frontend/replies/add' => 'zlecenia/dodaj-zgloszenie/<job_id>',
	'site_jobs/profile/jobs/my' => 'my-account/jobs',
	'site_jobs/profile/closet' => 'my-account/jobs/watchlist',
	'site_jobs/profile/closet/delete' => 'my-account/jobs/watchlist/remove/<id>',
	'site_jobs/profile/closet/add' => 'my-account/jobs/watchlist/save/<id>',
	'site_jobs/profile/jobs/promote' => 'my-account/jobs/upgrade/<id>',
	'site_jobs/profile/jobs/edit' => 'my-account/jobs/edit/<id>',
	'site_jobs/profile/jobs/renew' => 'my-account/jobs/renew/<id>',
	'site_jobs/profile/jobs/delete' => 'my-account/jobs/remove/<id>',
	'site_jobs/profile/jobs/statistics' => 'my-account/jobs/statistics/<id>',
	'site_notifier/notifier/jobs' => 'jobs/alert',
);