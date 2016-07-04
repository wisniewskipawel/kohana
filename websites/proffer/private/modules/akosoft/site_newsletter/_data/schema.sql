CREATE TABLE IF NOT EXISTS `newsletter_letters` (
  `letter_id` int(11) NOT NULL AUTO_INCREMENT,
  `letter_subject` varchar(256) NOT NULL DEFAULT '',
  `letter_message` text DEFAULT NULL,
  `accepted_ads` TINYINT NOT NULL DEFAULT '1',
  PRIMARY KEY (`letter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `newsletter_queue` (
  `queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` int(11) NOT NULL,
  `letter_id` int(11) NOT NULL,
  `queue_send_at` datetime DEFAULT NULL,
  PRIMARY KEY (`queue_id`),
  KEY `email_id` (`email_id`,`letter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL DEFAULT '',
  `email_sent_count` int(11) NOT NULL DEFAULT '0',
  `accept_ads` TINYINT NOT NULL DEFAULT '0',
  `email_token` VARCHAR( 16 ) NOT NULL,
  `status` TINYINT NOT NULL DEFAULT '0',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

INSERT INTO `emails` (`email_id`, `email_subject`, `email_content`, `email_description`, `email_alias`) VALUES(NULL, 'Potwierdzenie adresu e-mail w newsletterze', '<p>Witaj!</p>\n<br />\nAby zweryfikować adres e-mail, kliknij poniższy link:<br />\n%confirmation_link%<br />\n<br />\nLink prowadzi bezpośrednio do strony weryfikacji adresu e-mail. &nbsp;(Jeśli link nie działa, skopiuj pełny adres URL i wklej go w oknie &nbsp;adresowym przeglądarki).<br />\n<br />\nKliknięcie oznacza, że jesteś właścicielem tego adresu e-mail i wyrażasz zgodę na przetwarzanie swoich danych osobowych zgodnie z ustawą z dnia 29 sierpnia 1997 r. o Ochronie Danych Osobowych (Dz.U. nr 133, poz. 883) przez AkoPortal, a także wyrażasz zgodę na otrzymanie informacji handlowych środkami komunikacji elektronicznej przesyłanych przez serwis AkoPortal. Oczywiście w każdej chwili możesz zrezygnować.<br />\n<br />\nJeżeli nie wyrażasz takiej zgody lub ten mail był wysłany do Ciebie omyłkowo - zignoruj powyższą wiadomość.<br />\n<br />\nZ poważaniem,<br />\nAdministrator<br />\n<br />\n---<br />\nTen email został wygenerowany automatycznie. Prosimy nie odpowiadać na niego. W razie jakichkolwiek pytań prosimy o kontakt przez formularz kontaktowy znajdujący się na stronie: <a href="../../../content/kontakt">http://akosoft.pl/</a><a href="http://akosoft.pl/akoportal/strona/kontakt">akoportal/strona/kontakt</a>', 'Potwierdzenie adresu e-mail w newsletterze', 'newsletter_confirmation');
