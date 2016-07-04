CREATE TABLE IF NOT EXISTS `notifiers` (
  `notify_id` int(11) NOT NULL AUTO_INCREMENT,
  `notify_email` varchar(128) NOT NULL,
  `notify_provinces` varchar(128) NOT NULL,
  `notify_categories` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `token` varchar(16) DEFAULT NULL,
  `module` varchar(32) NOT NULL,
  PRIMARY KEY (`notify_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

