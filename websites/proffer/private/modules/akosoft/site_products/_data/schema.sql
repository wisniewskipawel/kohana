CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `product_type` tinyint(4) DEFAULT NULL,
  `product_title` varchar(256) NOT NULL DEFAULT '',
  `product_content` text NOT NULL,
  `product_manufacturer` VARCHAR( 64 ) NOT NULL DEFAULT '',
  `product_price` decimal(11,2) DEFAULT NULL,
  `product_price_to_negotiate` TINYINT( 1 ) NOT NULL DEFAULT '0',
  `product_person_type` varchar(16) NOT NULL DEFAULT '',
  `product_person` varchar(64) NOT NULL DEFAULT '',
  `product_province` int(11) DEFAULT NULL,
  `product_county` int(11) DEFAULT NULL,
  `product_city` varchar(32) NOT NULL DEFAULT '',
  `product_postal_code` varchar(32) NOT NULL DEFAULT '',
  `product_street` varchar(64) NOT NULL DEFAULT '',
  `product_map_lat` decimal(10,8) DEFAULT NULL,
  `product_map_lng` decimal(11,8) DEFAULT NULL,
  `product_email` varchar(64) NOT NULL DEFAULT '',
  `product_telephone` varchar(32) NOT NULL DEFAULT '',
  `product_fax` varchar(32) NOT NULL DEFAULT '',
  `product_www` varchar(128) NOT NULL DEFAULT '',
  `product_youtube` varchar(256) NOT NULL DEFAULT '',
  `product_allegro_url` VARCHAR( 256 ) NOT NULL DEFAULT '',
  `product_shop_url` VARCHAR( 256 ) NOT NULL DEFAULT '',
  `product_buy` TINYINT NOT NULL DEFAULT '0',
  `product_state` TINYINT NULL DEFAULT NULL,
  `product_distinction` tinyint(4) NOT NULL DEFAULT '0',
  `product_is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `product_is_sended` tinyint(1) NOT NULL DEFAULT '0',
  `product_promotion_availability` datetime DEFAULT NULL,
  `product_availability` datetime DEFAULT NULL,
  `product_date_added` datetime DEFAULT NULL,
  `product_date_updated` datetime DEFAULT NULL,
  `product_visits` int(11) NOT NULL DEFAULT '0',
  `ip_address` varbinary(16) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `products_to_users` (
  `product_to_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_to_user_id`),
  KEY `user_id` (`user_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `product_types` (`id`, `name`) VALUES
(1, 'Produkt'),
(2, 'Usługa');

CREATE TABLE IF NOT EXISTS `product_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(64) NOT NULL,
  `category_left` int(11) NOT NULL,
  `category_right` int(11) NOT NULL,
  `category_level` int(11) NOT NULL,
  `category_scope` int(11) NOT NULL,
  `category_parent_id` int(11) DEFAULT NULL,
  `category_meta_title` varchar(64) NOT NULL DEFAULT '',
  `category_meta_description` varchar(256) NOT NULL DEFAULT '',
  `category_meta_keywords` varchar(256) NOT NULL DEFAULT '',
  `category_meta_robots` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`),
  KEY `category_parent_id` (`category_parent_id`),
  KEY `category_left` (`category_left`,`category_right`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `product_categories` (`category_id`, `category_name`, `category_left`, `category_right`, `category_level`, `category_scope`, `category_parent_id`, `category_meta_title`, `category_meta_description`, `category_meta_keywords`, `category_meta_robots`) VALUES
(1, 'ROOT', 1, 2, 1, 1, NULL, '', '', '', '');

CREATE TABLE IF NOT EXISTS `products_to_categories` (
  `product_to_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`product_to_category_id`),
  KEY `category_id` (`category_id`,`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `product_availabilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `availability` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `product_availabilities` (`id`, `availability`) VALUES
(1, 8),
(2, 14),
(4, 30),
(5, 60),
(6, 90);

CREATE TABLE IF NOT EXISTS `product_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(32) NOT NULL DEFAULT '',
  `raw_tag` varchar(32) NOT NULL DEFAULT '',
  `counter` INT NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `raw_tag` (`raw_tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `product_to_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  UNIQUE KEY `product_id` (`product_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `emails` (`email_id`, `email_subject`, `email_content`, `email_description`, `email_alias`) VALUES
(NULL, 'Akceptacja produktu w serwisie AkoPortal', '<p><span style="font-family:verdana,geneva; font-size:11px">Szanowni Państwo!</span></p>\n\n<p>&nbsp;</p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Informujemy że Twój produkt dodany w serwisie AkoPortal został zaakceptowany!</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">%link%</span></p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<br />\n<span style="font-family:verdana,geneva; font-size:11px">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: test.pl</span></div>\n', 'Akceptacja produktu', 'product_approved'),
(NULL, 'Twój produkt wygasa za 2 dni!', '<p><span style="font-family:verdana,geneva; font-size:11px">Witaj!</span></p>\n\n<p>&nbsp;</p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Twój produkt %product_link% wygasa za 2 dni.</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Aby przedłużyć jego wyświetlanie, kliknij na link poniżej:</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">%renew_link%</span></p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n\n<p>&nbsp;</p>\n', 'Wygasający produkt dla zarejestrowanego użytkownika', 'products_expiring_registered'),
(NULL, 'Twój znajomy poleca Ci produkt!', '<p><span style="font-family:verdana,geneva; font-size:11px">Witaj!</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Tw&oacute;j znajomy poleca Ci produkt który znalazł w serwisie AkoPortal - więcej niż portal</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Aby go zobaczyć kliknij na link poniżej:</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">%link%</span></p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n\n<p>&nbsp;</p>\n', 'Polecanie produktu znajomemu', 'product_send_to_friend'),
(NULL, 'Twój produkt wygasa za 2 dni!', '<p><span style="font-family:verdana,geneva; font-size:11px">Witaj!</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px; line-height:1.6em">Twój produkt %product_link% wygasa za 2 dni.</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Aby dodać nowy produkt kliknij na link poniżej</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">%add_link%</span></p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n\n<p>&nbsp;</p>\n', 'Wygasający produkt dla niezarejestrowanego użytkownika', 'products_expiring_not_registered'),
(NULL, 'Wiadomość ze strony produktu', '<p>temat: %email.subject%</p>\n\n<p>od %email.from%</p>\n\n<p>tresc: %email.message%</p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu &nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Email wysyłany ze strony produktu do autora', 'send_to_product'),
(NULL, 'Nowy produkt do potwierdzenia!', '<p>Nowy produkt w serwisie oczykujący na zatwierdzenie.&nbsp;</p>\n<p>%admin_link%</p>', 'Email wysyłany do administratora z prośbą o akceptacje produktu', 'product_approve'),
(NULL, 'Potwierdzenie zamówienia', '<p>Witaj!</p>\n\n<p>Potwierdzenie zamówienia na produkt/usługę:</p>\n\n<p>%product.link%</p>\n\n<p>&nbsp;</p>\n\n<p>Ilość: %quantity%</p>\n\n<p>&nbsp;</p>\n\n<p>Dane kontaktowe:</p>\n\n<p>%person_type%</p>\n\n<p>%name%</p>\n\n<p>Ulica: %street%</p>\n\n<p>Kod pocztowy:%postal_code%</p>\n\n<p>Miejscowość: %city%</p>\n\n<p>e-mail: %email%</p>\n\n<p>tel. %phone%</p>\n\n<p>&nbsp;</p>\n\n<p>Uwagi:</p>\n\n<p>%remarks%</p>\n\n<p>&nbsp;</p>\n\n<p>Z poważaniem,<br />\nZespół AkoPortal</p>\n\n<p>&nbsp;</p>\n\n<p>---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</p>\n', 'Wiadomość z potwierdzeniem zamówienia produktu (do kupującego)', 'product_order_buyer'),
(NULL, 'Nowe zamówienie', '<p>Witaj!</p>\n\n<p>Masz nowe zamówienie na produkt/usługę:</p>\n\n<p>%product.link%</p>\n\n<p>&nbsp;</p>\n\n<p>Ilość: %quantity%</p>\n\n<p>&nbsp;</p>\n\n<p>Dane zamawiającego:</p>\n\n<p>%person_type%</p>\n\n<p>%name%</p>\n\n<p>Ulica: %street%</p>\n\n<p>Kod pocztowy:%postal_code%</p>\n\n<p>Miejscowość: %city%</p>\n\n<p>e-mail: %email%</p>\n\n<p>tel. %phone%</p>\n\n<p>&nbsp;</p>\n\n<p>Uwagi:</p>\n\n<p>%remarks%</p>\n\n<p>&nbsp;</p>\n\n<p>Z poważaniem,<br />\nZespół AkoPortal</p>\n\n<p>&nbsp;</p>\n\n<p>---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</p>\n', 'Wiadomość z potwierdzeniem zamówienia produktu (do sprzedającego)', 'product_order_seller');

INSERT INTO `documents` (`document_id`, `document_title`, `document_content`, `document_url`, `document_alias`, `document_is_deletable`, `document_meta_title`, `document_meta_keywords`, `document_meta_description`) VALUES
(NULL, 'Dodawanie produktu', '<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-size:medium"><strong><span style="font-family:verdana,geneva"><img alt="alert" src="../media/img/alert.png" style="vertical-align:middle" />&nbsp;<span style="font-family:verdana,geneva,sans-serif">Nie jesteś zalogowany!</span></span></strong></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:12px">- brak możliwości edycji produktu</span><br />\n<span style="font-size:small">- produkt akceptowany przez administratora</span></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">Aby w pełni korzystać z możliwości serwisu możesz się <strong><a href="../rejestracja">zarejestrować</a></strong>. Otrzymasz dostęp do funkcji:</span></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<div style="text-align: center;"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">- możliwość edycji produktu&nbsp;</span><br />\n<span style="font-size:small">- możliwość usunięcia produktu</span><br />\n<span style="font-size:small">- możliwość dodania <strong>10&nbsp;zdjęć do produktu</strong></span><br />\n<span style="font-size:small">- natychmiastowe dodanie produktu</span><br />\n<span style="font-size:small">- <strong>schowek</strong> na interesujące produkty&nbsp;</span><br />\n<span style="font-size:small">- jednorazowa akceptacja regulaminu</span><br />\n<span style="font-size:small">- promocje dla użytkowników</span></span></div>\n\n<div style="text-align: center;"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">- autouzupełnianie danych adresowych</span></span></div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p>&nbsp;</p>\n', 'product-pre-add', 'product_pre_add', 0, 'Dodaj produkt w serwisie AkoPortal', 'produkty', 'Darmowe produkty - AkoPortal');

INSERT INTO `config` (`config_id`, `config_group_name`, `config_key`, `config_value`) VALUES
(NULL, 'modules.site_products', 'provinces_enabled', 'b:1;'),
(NULL, 'modules.site_products', 'confirm_required', 'b:0;'),
(NULL, 'modules.site_products', 'confirmation_email', 'b:0;'),
(NULL, 'modules.site_products', 'email_view_disabled', 'b:0;'),
(NULL, 'modules.site_products', 'home_box_products', 's:1:"6";'),
(NULL, 'modules.site_products.photos_count', 'guest', 's:1:"3";'),
(NULL, 'modules.site_products.photos_count', 'registered', 's:1:"6";'),
(NULL, 'modules.site_products', 'promotion_time', 's:2:"20";'),
(NULL, 'modules.site_products.free_promotion', '1', 's:1:"5";'),
(NULL, 'modules.site_products.free_promotion', '2', 's:2:"10";');