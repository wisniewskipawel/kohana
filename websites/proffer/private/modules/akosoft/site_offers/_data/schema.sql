CREATE TABLE IF NOT EXISTS `offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `offer_title` varchar(256) NOT NULL DEFAULT '',
  `offer_content` text NOT NULL,
  `offer_price` decimal(11,2) DEFAULT NULL,
  `offer_price_old` decimal(11,2) DEFAULT NULL,
  `offer_person_type` varchar(16) NOT NULL DEFAULT '',
  `offer_person` varchar(64) NOT NULL DEFAULT '',
  `province_select` int(11) DEFAULT NULL,
  `offer_county` int(11) DEFAULT NULL,
  `offer_city` varchar(32) NOT NULL DEFAULT '',
  `offer_postal_code` varchar(32) NOT NULL DEFAULT '',
  `offer_street` varchar(64) NOT NULL DEFAULT '',
  `offer_telephone` varchar(32) NOT NULL DEFAULT '',
  `offer_email` varchar(64) NOT NULL DEFAULT '',
  `offer_fax` varchar(32) NOT NULL DEFAULT '',
  `offer_www` varchar(128) NOT NULL DEFAULT '',
  `offer_company_nip` VARCHAR( 16 ) NULL DEFAULT NULL,
  `download_limit` int(11) NOT NULL DEFAULT '0',
  `download_counter` int(11) NOT NULL DEFAULT '0',
  `limit_per_user` int(11) NOT NULL DEFAULT '0',
  `coupon_expiration` DATE NULL,
  `offer_visits` int(11) NOT NULL DEFAULT '0',
  `offer_distinction` tinyint(4) NOT NULL DEFAULT '0',
  `offer_is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `offer_is_paid` TINYINT NOT NULL DEFAULT  '0',
  `offer_notifier_sent` tinyint(4) NOT NULL DEFAULT '0',
  `offer_hash` varchar(32) NOT NULL DEFAULT '',
  `offer_availability` datetime DEFAULT NULL,
  `offer_promotion_availability` datetime DEFAULT NULL,
  `offer_date_added` datetime DEFAULT NULL,
  `offer_date_updated` datetime DEFAULT NULL,
  `ip_address` varbinary(16) DEFAULT NULL,
  PRIMARY KEY (`offer_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `offers_to_categories` (
  `offer_to_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  PRIMARY KEY (`offer_to_category_id`),
  KEY `category_id` (`category_id`,`offer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `offers_to_users` (
  `offer_to_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  PRIMARY KEY (`offer_to_user_id`),
  KEY `user_id` (`user_id`,`offer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `offer_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_left` int(11) NOT NULL,
  `category_right` int(11) NOT NULL,
  `category_level` int(11) NOT NULL,
  `category_scope` int(11) NOT NULL,
  `category_parent_id` int(11) DEFAULT NULL,
  `category_name` varchar(64) NOT NULL DEFAULT '',
  `category_meta_description` varchar(128) NOT NULL DEFAULT '',
  `category_meta_keywords` text DEFAULT NULL,
  `category_meta_robots` varchar(64) NOT NULL DEFAULT '',
  `category_meta_revisit_after` varchar(64) NOT NULL DEFAULT '',
  `category_meta_title` varchar(256) NOT NULL DEFAULT '',
  `category_text` text DEFAULT NULL,
  `category_age_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `category_image` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `category_parent_id` (`category_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `offer_categories` (`category_id`, `category_left`, `category_right`, `category_level`, `category_scope`, `category_parent_id`, `category_name`, `category_meta_description`, `category_meta_keywords`, `category_meta_robots`, `category_meta_revisit_after`, `category_meta_title`, `category_text`, `category_age_confirm`, `category_image`) VALUES
(1, 1, 2, 1, 1, NULL, 'ROOT', '', '', '', '', '', '', 0, NULL);

CREATE TABLE IF NOT EXISTS `coupon_owners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `token` varchar(16) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `offer_id` (`offer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `emails` (`email_id`, `email_subject`, `email_content`, `email_description`, `email_alias`) VALUES
(NULL, 'Kupon promocyjny AkoPortal', '<p>Witaj,</p>\n\n<p>W załączniku do tej wiadomości, przesyłamy Ci kupon promocyjny z oferty:<br />\n%offer.url%</p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px; line-height:1.6em">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n', 'Kupony - wiadomość z kuponem', 'coupon_send'),
(NULL, 'Powiadomienie o pobraniu kuponu promocyjnego', '<p>Witaj,</p>\n\n<p>Informujemy o pobraniu Twojego kuponu promocyjnego.</p>\n\n<p>Oferta: %offer.url%</p>\n\n<p>Adres e-mail klienta: %coupon_owner.email%</p>\n\n<p>Kod klienta: %coupon_owner.token%</p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px; line-height:1.6em">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n', 'Kupony - powiadomienie o pobraniu kuponu', 'coupon_send_confirmation'),
(NULL, 'Nowe oferty w serwisie AkoPortal', '<p>Nowe oferty w serwisie AkoPortal</p>\n\n<p>&nbsp;</p>\n\n<p>%offers_links%</p>\n\n<p>&nbsp;</p>\n\n<p>--&nbsp;</p>\n\n<p>Wiadomość tą otrzymujesz ponieważ subskrybowałeś listę powiadomień w serwisie AkoPortal</p>\n\n<p>%unsubscibe_link%</p>\n', 'Powiadamiacz ofert - wysyłany do zapisanego użytkownika.', 'notifier_offers'),
(NULL, 'Akceptacja oferty w serwisie', '<p><span style="font-family: verdana, geneva; font-size: 11px;">Szanowni Państwo!</span></p>\n<p>&nbsp;</p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Informujemy że Twoja oferta została zaakceptowana!</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">%link%</span></p>\n<p>&nbsp;</p>\n<div><span style="font-family: verdana, geneva; font-size: 11px;">Z poważaniem,</span><br /><br /><span style="font-family: verdana, geneva; font-size: 11px;">Zespół AkoPortal</span></div>\n<div><span style="font-family: verdana, geneva; font-size: 11px;"><br /></span></div>\n<div><span style="font-family: verdana, geneva; font-size: 11px;"><span>---</span><br /><span>Ten email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: test.pl</span><br /></span></div>', 'Akceptacja oferty', 'offer_approved'),
(NULL, 'Nowa oferta do potwierdzenia!', '<p>Nowa oferta w serwisie oczykująca na zatwierdzenie.&nbsp;</p>\n<p>%admin_link%</p>', 'Email wysyłany do administratora z prośbą o akceptację oferty', 'offer_approve'),
(NULL, 'Twój znajomy poleca Ci ofertę!', '<p><span style="font-family: verdana, geneva; font-size: 11px;">Witaj!</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Twój znajomy poleca Ci ofertę, którą znalazł? w serwisie AkoPortal - więcej niż portal</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Aby je zobaczyć kliknij na link poniżej:</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">%link%</span></p>\n<p>&nbsp;</p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Z Poważaniem,</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Zespół AkoPortal</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;"><br /></span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">---<br />Ten email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: test.pl</span></p>', 'Wysłanie oferty firmy znajomemu.', 'offer_send_to_friend'),
(NULL, 'Twoja oferta wygasa za 2 dni!', '<p><span style="font-family: verdana, geneva; font-size: 11px;">Witaj!</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;"><br /></span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Twoja oferta %offer_link% wygasa za 2 dni.</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Aby ją przedłużyć kliknij na link poniżej:</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">%renew_link%</span></p>\n<p>&nbsp;</p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Z poważaniem,</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Zespół AkoPortal</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;"><br /></span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">---<br />Ten email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: test.pl<br /></span></p>', 'Wygasająca oferta dla zarejestrowanego użytkownika', 'offers_expiring_registered'),
(NULL, 'Twoja oferta wygasa za 2 dni!', '<p><span style="font-family: verdana, geneva; font-size: 11px;">Witaj!</span></p>\n<p>&nbsp;</p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Twoja oferta %offer_link% wygasa za 2 dni.</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Aby dodać nową ofertę kliknij na link poniżej</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">%add_link%</span></p>\n<p>&nbsp;</p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Z poważaniem,</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">Zespół AkoPortal</span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;"><br /></span></p>\n<p><span style="font-family: verdana, geneva; font-size: 11px;">---</span><br /><span style="font-family: verdana, geneva; font-size: 11px;">Ten email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: test.pl</span></p>', 'Wygasająca oferta dla niezarejestrowanego użytkownika', 'offers_expiring_not_registered'),
(NULL, 'Wiadomość ze strony oferty', '<p>temat: %email.subject%</p>\n\n<p>od %email.from%</p>\n\n<p>tresc: %email.message%</p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu &nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Wiadomość kontaktowa ze strony oferty', 'offers.contact');

INSERT INTO `documents` (`document_id`, `document_title`, `document_content`, `document_url`, `document_alias`, `document_is_deletable`, `document_meta_title`, `document_meta_keywords`, `document_meta_description`) VALUES
(NULL, 'Dodaj ofertę', '<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-size:medium"><strong><span style="font-family:verdana,geneva"><img alt="alert" src="../media/img/alert.png" style="vertical-align:middle" />&nbsp;<span style="font-family:verdana,geneva,sans-serif">Nie jesteś zalogowany!</span></span></strong></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:12px">- brak możliwości edycji oferty</span><br />\n<span style="font-size:small">- oferta akceptowana&nbsp;przez administratora</span></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p style="text-align:center"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">Aby w pełni korzystać z możliwości serwisu możesz się <strong><a href="../rejesracja">zarejestrować</a></strong>. Otrzymasz dostęp do funkcji:</span></span></p>\n\n<p style="text-align:center">&nbsp;</p>\n\n<div style="text-align: center;"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">- możliwość edycji oferty&nbsp;</span><br />\n<span style="font-size:small">- możliwość usuwania oferty</span></span></div>\n\n<div style="text-align: center;"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">- statystyki pobrania ofert</span><br />\n<span style="font-size:small">- możliwość promocji w&nbsp;<strong>dowolnym momencie</strong></span><br />\n<span style="font-size:small">- natychmiastowe dodawanie oferty</span><br />\n<span style="font-size:small">- <strong>schowek</strong> na interesujące oferty, ogłoszenia, firmy&nbsp;</span><br />\n<span style="font-size:small">- jednorazowa akceptacja regulaminu</span><br />\n<span style="font-size:small">- promocje dla użytkowników</span></span></div>\n\n<div style="text-align: center;"><span style="font-family:verdana,geneva,sans-serif"><span style="font-size:small">- autouzupełnianie danych adresowych</span></span></div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<p style="text-align:center">&nbsp;</p>\n\n<p>&nbsp;</p>\n', '', 'offer_pre_add', 0, 'Dodaj darmową ofertę w serwisie AkoPortal', '', '');
