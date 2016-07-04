CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_hash` varchar(40) NOT NULL,
  `user_registration_date` int(11) DEFAULT NULL,
  `user_last_login_date` int(11) DEFAULT NULL,
  `user_ip` varchar(15) DEFAULT NULL,
  `user_host` varchar(256) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `user_autologin` varchar(40) NOT NULL DEFAULT '0',
  `user_newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `user_is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `fb_user_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `users_data` (
  `user_id` int(11) NOT NULL,
  `users_data_person_type` varchar(64) NOT NULL DEFAULT '',
  `users_data_person` varchar(128) NOT NULL DEFAULT '',
  `users_data_province` int(11) DEFAULT NULL,
  `users_data_county` int(11) DEFAULT NULL,
  `users_data_postal_code` varchar(32) NOT NULL DEFAULT '',
  `users_data_city` varchar(32) NOT NULL DEFAULT '',
  `users_data_street` varchar(64) NOT NULL DEFAULT '',
  `users_data_telephone` varchar(32) NOT NULL DEFAULT '',
  `users_data_fax` varchar(32) NOT NULL DEFAULT '',
  `users_data_www` varchar(256) NOT NULL DEFAULT '',
  `announcement_points` int(11) NOT NULL DEFAULT '0',
  `offer_points` int(11) NOT NULL DEFAULT '0',
  `catalog_discount` int(11) NOT NULL DEFAULT '0',
  `announcements_moto_points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL DEFAULT '',
  `group_description` varchar(256) NOT NULL DEFAULT '',
  `group_is_admin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `users_groups` (`group_id`, `group_name`, `group_description`, `group_is_admin`) VALUES
(1, 'Administrator', 'Dostęp do Panelu Administratora', 1),
(3, 'Adsystem', 'Dostęp do panelu zarządzania reklamą', 0),
(4, 'SuperAdministrator', 'Tworzenie kopii zapasowych, zarządzanie administratorami', 1);

CREATE TABLE IF NOT EXISTS `users_to_groups` (
  `user_to_user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_to_user_group_id`),
  KEY `user_id` (`user_id`,`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `emails` (`email_id`, `email_subject`, `email_content`, `email_description`, `email_alias`) VALUES(NULL, 'Zmienił się stan punktów promocyjnych oraz zniżek na Twoim koncie', '<p>Witaj %user_name%,</p>\n\n<p>Zmienił się stan punktów promocyjnych oraz zniżek na Twoim koncie.<br />\nPoniżej znajdziesz informację o aktualnym stanie promocji na Twoim koncie:</p>\n\n<ol>\n	<li>Wysokość zniżki na dodanie firmy do Katalogu firm:&nbsp;<strong>%company_discount%%</strong> (obowiązuje tylko przy płatnościach PayPal, PayU i przelew zwykły).</li>\n	<li>Ilość punktów promocyjnych do wykorzystania przy promowaniu ogłoszeń:&nbsp;<strong>%announcement_points%</strong>.</li>\n	<li>Ilość punktów promocyjnych do wykorzystania przy promowaniu ofert:&nbsp;<strong>%offer_points%</strong>.<br />\n	&nbsp;</li>\n</ol>\n\n<p></p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px">Zespół AkoPortal</span></div>\n\n<div></div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n', 'Szablon wiadomości z informacjami o zmianach w promocjach dla użytkownika', 'user_promotions');

CREATE TABLE IF NOT EXISTS `email_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `users_groups_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `permission` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
