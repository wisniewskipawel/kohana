CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `params` text,
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
