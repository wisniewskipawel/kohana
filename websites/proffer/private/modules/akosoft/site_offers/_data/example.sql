TRUNCATE TABLE offer_categories;

INSERT INTO `offer_categories` (`category_id`, `category_left`, `category_right`, `category_level`, `category_scope`, `category_parent_id`, `category_name`, `category_meta_description`, `category_meta_keywords`, `category_meta_robots`, `category_meta_revisit_after`, `category_meta_title`, `category_text`, `category_age_confirm`, `category_image`) VALUES
(1, 1, 22, 1, 2, NULL, 'ROOT', '', '', '', '', '', '', 0, NULL),
(218, 8, 9, 2, 2, 1, 'Edukacja/szkolenia', 'Promocje firm Edukacja/szkolenia', 'Promocje Edukacja/szkolenia', 'all', '2 days', 'Specjalne oferty Edukacja/szkolenia', '', 0, 1364919254),
(215, 2, 3, 2, 2, 1, 'Auto-moto', 'Promocje Auto-moto firm', 'promocje, ', 'all', '2 days', 'Promocje firm motoryzacyjnych', '', 0, 1364919215),
(216, 4, 5, 2, 2, 1, 'Biznes', 'Oferty biznesowe firm', 'biznes, oferta', 'all', '2 days', 'Oferty biznesowe firm', '', 0, 1364919178),
(217, 6, 7, 2, 2, 1, 'Dom i ogród', 'Oferty specjalne Dom i ogród', 'promocje Dom i ogród, ', 'all', '2 days', 'Oferty specjalne Dom i ogród', '', 0, 1364919235),
(219, 10, 11, 2, 2, 1, 'Gastronomia/restauracje', 'Gastronomia, restauracje', 'Gastronomia, restauracje, rabaty', 'all', '2 days', 'Gastronomia/restauracje', '', 0, 1364919278),
(221, 12, 13, 2, 2, 1, 'Handel i zakupy', 'Handel i zakupy', 'Handel i zakupy', 'all', '2 days', 'Handel i zakupy', '', 0, 1364919294),
(222, 14, 15, 2, 2, 1, 'Rozrywka', 'Rozrywka', 'rozrywka', 'all', '2 days', 'AkoPortal - rozrywka', '', 0, 1364919311),
(223, 16, 17, 2, 2, 1, 'Transport', 'Transport', 'transport', 'all', '2 days', 'AkoPortal - Transport', '', 0, 1364919327),
(224, 18, 19, 2, 2, 1, 'Turystyka', 'Turystyka', 'Turystyka', 'all', '2 days', 'AkoPortal - Turystyka', '', 0, 1364919341),
(225, 20, 21, 2, 2, 1, 'Zdrowie i Uroda', 'Zdrowie i Uroda', 'Zdrowie i Uroda', 'all', '2 days', 'AkoPortal - Zdrowie i Uroda', '', 0, 1364919355);

INSERT INTO `offers` (`offer_id`, `user_id`, `category_id`, `company_id`, `offer_title`, `offer_content`, `offer_price`, `offer_price_old`, `offer_person_type`, `offer_person`, `province_select`, `offer_county`, `offer_city`, `offer_postal_code`, `offer_street`, `offer_telephone`, `offer_email`, `offer_fax`, `offer_www`, `download_limit`, `download_counter`, `limit_per_user`, `offer_visits`, `offer_distinction`, `offer_is_approved`, `offer_notifier_sent`, `offer_hash`, `offer_availability`, `offer_promotion_availability`, `offer_date_added`, `offer_date_updated`, `ip_address`, `offer_is_paid`) VALUES
(1, 1, 216, NULL, 'Rabat na oprogramowanie AkoNieruchomości', '<p>Specjalan cena na oprogramowanie firmy AkoSoft</p>\n\n<p>AkoNieruchomości z rabatem 50%</p>', 124.00, 248.00, 'company', 'AkoSoft', 1, 1001, '', '', '', '', 'noreply@akosoft.pl', '', '', 50, 1, 0, 10, 3, 1, 0, '3qks8i5ah9KaSCPHcampqsWQw1G11TIf', '2015-06-27 10:37:59', '2015-04-18 10:38:13', '2013-03-29 09:37:59', '2013-07-01 13:39:48', '', 1),
(2, 1, 215, 1, 'Specjalna promocja na mycie pojzadu', '<p>Umyj samh z rabatem - zapraszamy do fikcyjnej pormocji!</p>\n\n<p>Opis firmy i działalności ....</p>', 35.00, 116.67, '', '', 0, 0, '', '', '', '', '', '', '', 500, 0, 0, 4, 3, 1, 0, '7ZDit2oCZeYPUFF6F1EbsQ6pIspOUaE2', '2015-06-27 11:13:11', '2015-04-18 11:13:39', '2013-03-29 10:13:11', '2013-07-01 13:40:23', '', 1),
(3, 1, 217, 1, 'Specjalan oferta na podlewanie ogrodu', '<p>Firma Ogrodex zparasza do promocyjnego skorzystania z usługi podlewania ogrodu.</p>', 65.00, 100.00, '', '', 0, 0, '', '', '', '', '', '', '', 400, 0, 0, 4, 0, 1, 0, 'lUw0hN4pXUnccLIoTLNpNByu3PknNosv', '2015-06-27 11:15:55', '0000-00-00 00:00:00', '2015-03-29 10:15:55', '2013-07-01 13:40:35', '', 1),
(4, 1, 218, 2, 'Szkolenie z marketingu', '<p>Obniżamy cenę na szkolenie z e-mail marketingu.</p>', 350.00, 1400.00, '', '', 0, 0, '', '', '', '', '', '', '', 150, 0, 0, 2, 3, 1, 0, 'Sue8VgD0ARrj5SJ3IR7xpds7fcuzjlip', '2015-05-28 11:21:58', '2015-04-18 11:22:43', '2013-03-29 10:21:58', '2013-04-02 18:18:10', '', 1),
(5, NULL, 215, NULL, 'Oferta przykładowa', '<p>Treść oferty przykładowej</p>', 200.00, 250.00, 'person', 'Marek', 1, 1000, '', '', '', '', 'noreply@akosoft.pl', '', '', 30, 0, 0, 2, 0, 1, 0, 'FhWReKJgM7Op5ke1g0mhJfwfrDMGJEmf', '2015-06-27 11:58:32', '0000-00-00 00:00:00', '2013-03-29 10:58:32', '2013-04-02 18:17:43', '', 1),
(6, NULL, 215, NULL, 'Przykładowa oferta wersji demo', '<p>Przykładowa oferta wersji demo</p>\n\n<ul><li>jeden</li>\n	<li>dwa</li>\n	<li>trzy</li>\n</ul><p></p>\n\n<p></p>', 210.00, 600.00, 'person', 'Admin', 8, 8000, '', '', '', '', 'noreply@akosoft.pl', '', '', 120, 0, 0, 1, 0, 1, 0, 'iTgIzAuyOoWDZZqyYoZC03VAJHyxMM3P', '2015-05-28 12:01:15', '0000-00-00 00:00:00', '2013-03-29 11:01:15', '2013-04-02 18:17:30', '', 1),
(7, 1, 216, 8, 'Przykładowa oferta 1', '<p>Przykładowa oferta 1</p>', 25.00, 250.00, '', '', 0, 0, '', '', '', '', '', '', '', 240, 0, 0, 2, 0, 1, 0, 'WKtIpMwdo3F4IMWgv2fmxqBfTpXs3GMP', '2015-06-27 12:39:35', '0000-00-00 00:00:00', '2013-03-29 11:39:35', '2013-04-02 18:17:58', '', 1),
(8, 1, 217, 6, 'Przykładowa oferta 1', '<p>Przykładowa oferta 1</p>', 123.00, 164.00, '', '', 0, 0, '', '', '', '', '', '', '', 35, 0, 0, 3, 0, 1, 0, 'SHnAFyzSJx3DfKpTohYHTpHyM2KMRbMr', '2015-06-27 12:42:08', '0000-00-00 00:00:00', '2013-03-29 11:42:08', '2013-04-02 18:16:44', '', 1),
(9, NULL, 215, NULL, 'Oferta testowa bez rejestracji', '<p>Oferta testowa bez rejestracji</p>', 126.00, 193.85, 'person', 'Admin', 1, 1000, '', '', '', '', 'noreply@akosoft.pl', '', '', 200, 0, 0, 2, 0, 1, 0, '7uk5VwCSn8K1lFmpTQgXEyXZnApClGsq', '2015-06-02 09:30:52', '0000-00-00 00:00:00', '2013-04-03 09:30:52', '2013-07-01 13:41:50', '', 1);


INSERT INTO `offers_to_categories` (`offer_to_category_id`, `category_id`, `offer_id`) VALUES
(1, 216, 1),
(2, 1, 1),
(3, 215, 2),
(4, 1, 2),
(5, 217, 3),
(6, 1, 3),
(7, 218, 4),
(8, 1, 4),
(9, 215, 5),
(10, 1, 5),
(11, 215, 6),
(12, 1, 6),
(13, 216, 7),
(14, 1, 7),
(15, 217, 8),
(16, 1, 8),
(17, 215, 9),
(18, 1, 9);

INSERT INTO `config` (`config_id`, `config_group_name`, `config_key`, `config_value`) VALUES
(NULL, 'modules.site_offers.settings', 'provinces_enabled', 's:1:"1";'),
(NULL, 'modules.site_offers.settings', 'confirm_required', 's:1:"1";'),
(NULL, 'modules.site_offers.settings', 'confirmation_email', 's:1:"1";'),
(NULL, 'modules.site_offers.settings', 'promotion_time', 's:2:"20";'),
(NULL, 'modules.site_offers.settings', 'email_view_disabled', 's:1:"0";'),
(NULL, 'modules.site_offers.payment.promote.premium_plus', 'disabled', 's:1:"0";'),
(NULL, 'modules.site_offers.payment.dotpay.sms.promote.premium_plus', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_offers.payment.dotpay.sms.promote.premium_plus', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_offers.payment.dotpay.sms.promote.premium_plus', 'price', 's:1:"1";'),
(NULL, 'modules.site_offers.payment.dotpay.sms.promote.premium_plus', 'konektor', 's:5:"76025";'),
(NULL, 'modules.site_offers.payment.dotpay.online.promote.premium_plus', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_offers.payment.dotpay.online.promote.premium_plus', 'service_id', 's:5:"demo1";'),
(NULL, 'modules.site_offers.payment.dotpay.online.promote.premium_plus', 'price', 's:1:"1";'),
(NULL, 'modules.site_offers.payment.transfer.promote.premium_plus', 'enabled', 's:1:"1";'),
(NULL, 'modules.site_offers.payment.transfer.promote.premium_plus', 'price', 's:1:"1";');