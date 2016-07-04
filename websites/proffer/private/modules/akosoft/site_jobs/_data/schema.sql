CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `title` varchar(256) NOT NULL DEFAULT '',
  `content` text,
  `price` decimal(11,2) DEFAULT NULL,
  `person_type` varchar(16) NOT NULL DEFAULT '',
  `person` varchar(64) NOT NULL DEFAULT '',
  `province` int(11) DEFAULT NULL,
  `county` int(11) DEFAULT NULL,
  `city` varchar(32) NOT NULL DEFAULT '',
  `postal_code` varchar(32) NOT NULL DEFAULT '',
  `street` varchar(64) NOT NULL DEFAULT '',
  `telephone` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `www` varchar(128) NOT NULL DEFAULT '',
  `map_lat` decimal(10,8) DEFAULT NULL,
  `map_lng` decimal(11,8) DEFAULT NULL,
  `distinction` tinyint(4) NOT NULL DEFAULT '0',
  `visits` int(11) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_paid` tinyint(4) NOT NULL DEFAULT '0',
  `is_notifier_sent` tinyint(4) NOT NULL DEFAULT '0',
  `is_expired_send` tinyint(4) NOT NULL DEFAULT '0',
  `date_realization_limit` DATE NULL DEFAULT NULL,
  `date_promotion_availability` datetime DEFAULT NULL,
  `date_availability` datetime DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `ip_address` varbinary(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `job_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_left` int(11) NOT NULL,
  `category_right` int(11) NOT NULL,
  `category_level` int(11) NOT NULL,
  `category_scope` int(11) DEFAULT NULL,
  `category_parent_id` int(11) DEFAULT NULL,
  `category_name` varchar(64) NOT NULL DEFAULT '',
  `category_meta_description` varchar(128) NOT NULL DEFAULT '',
  `category_meta_keywords` text DEFAULT NULL,
  `category_meta_robots` varchar(64) NOT NULL DEFAULT '',
  `category_meta_revisit_after` varchar(64) NOT NULL DEFAULT '',
  `category_meta_title` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`),
  KEY `category_parent_id` (`category_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `job_categories` (`category_id`, `category_left`, `category_right`, `category_level`, `category_scope`, `category_parent_id`, `category_name`, `category_meta_description`, `category_meta_keywords`, `category_meta_robots`, `category_meta_revisit_after`, `category_meta_title`) VALUES
(1, 1, 2, 1, 2, NULL, 'ROOT', '', '', '', '', '');

CREATE TABLE IF NOT EXISTS `jobs_closet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`job_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `jobs_to_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`job_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `job_availabilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `availability` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `job_availabilities` (`id`, `availability`) VALUES
(1, 8),
(2, 14),
(4, 30),
(5, 60),
(6, 90);

CREATE TABLE IF NOT EXISTS `job_category_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `label` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(8) NOT NULL DEFAULT '',
  `options` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `job_category_to_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`category_field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `job_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `category_field_id` int(11) NOT NULL,
  `value` varchar(256) NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_id` (`job_id`,`category_field_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `job_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `price_unit` varchar(32) NOT NULL DEFAULT '',
  `ip_address` varbinary(16) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `job_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `ip_address` varbinary(16) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `parent_comment_id` (`parent_comment_id`),
  KEY `user_id` (`user_id`),
  KEY `lft` (`lft`,`rgt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

INSERT INTO `emails` (`email_id`, `email_subject`, `email_content`, `email_description`, `email_alias`) VALUES
(NULL, 'Twój znajomy przesłał Ci zlecenie!', '<p><span style="font-family:verdana,geneva; font-size:11px">Witaj!</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Tw&oacute;j znajomy przesłał Ci zlecenie kt&oacute;re znalazł w serwisie AkoPortal - więcej niż portal</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">Aby je zobaczyć kliknij na link poniżej:</span></p>\n\n<p><span style="font-family:verdana,geneva; font-size:11px">%link%</span></p>\n\n<p>&nbsp;</p>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">Z poważaniem,</span><br />\n<span style="font-family:verdana,geneva; font-size:11px">Zesp&oacute;ł AkoPortal</span></div>\n\n<div>&nbsp;</div>\n\n<div><span style="font-family:verdana,geneva; font-size:11px">---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie:&nbsp;test.pl</span></div>\n\n<p>&nbsp;</p>\n', 'Wysłanie zlecenia znajomemu.', 'jobs.send_to_friend'),
(NULL, 'Wiadomość ze strony zlecenia', '<p>temat: %email.subject%</p>\n\n<p>od %email.from%</p>\n\n<p>tresc: %email.message%</p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu ogłoszeniowego&nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Wiadomość kontaktowa ze strony zlecenia', 'jobs.contact'),
(NULL, 'Pytanie ze strony zlecenia', '<p>od %comment.user.name% %comment.user.email%</p>\n\n<p>tresc: %comment.body%</p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu ogłoszeniowego&nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Pytanie ze strony zlecenia', 'jobs.comment_add'),
(NULL, 'Pojawił się nowy wykonawca Twojego zlecenia', '<p>Wykonawca: %reply.user.name% %reply.user.email%</p>\n\n<p>Kwota: %reply.price% %reply.price_unit%</p>\n\n<p>Treść zgłoszenia: %reply.content%</p>\n\n<p>Zlecenie: <a href="%job.url%">%job.title%</a></p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu ogłoszeniowego&nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Zgłoszenie wykonania zlecenia', 'jobs.reply_add'),
(NULL, 'Wyświetlanie Twojego zlecenia zostało zakończone', '<p>Zlecenie: <a href="%job.url%" target="_blank">%job.title%</a></p>\n\n<p>Ilość zgłoszeń: %job.count_replies%</p>\n\n<p>&nbsp;</p>\n\n<p>--</p>\n\n<p>Wiadomość wysłana z serwisu ogłoszeniowego&nbsp;</p>\n\n<p><a href="http://akosoft.pl/akoportal">AkoPortal</a></p>\n', 'Zakończenie wyświetlania zlecenia', 'jobs.expired'),
(NULL, 'Nowe zlecenia w serwisie AkoPortal.', '<p>Nowe zlecenia w serwisie AkoPortal</p>\n\n<p>&nbsp;</p>\n\n<p>%jobs_links%</p>\n\n<p>&nbsp;</p>\n\n<p>--&nbsp;</p>\n\n<p>Wiadomość tą otrzymujesz ponieważ subskrybowałeś listę powiadomień w serwisie AkoPortal</p>\n\n<p>%unsubscibe_link%</p>\n', 'Powiadamiacz zleceń - wysyłany do zapisanego użytkownika.', 'jobs.notifier');
