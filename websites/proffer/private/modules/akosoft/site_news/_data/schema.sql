CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(256) NOT NULL DEFAULT '',
  `news_content` text DEFAULT NULL,
  `news_date_added` int(11) DEFAULT NULL,
  `news_first_image` int(11) DEFAULT NULL,
  `news_is_published` tinyint(4) NOT NULL DEFAULT '0',
  `news_visible_from` int(11) DEFAULT NULL,
  `news_image` int(11) DEFAULT NULL,
  `news_meta_title` varchar(64) NOT NULL DEFAULT '',
  `news_meta_description` varchar(256) NOT NULL DEFAULT '',
  `news_meta_keywords` varchar(256) NOT NULL DEFAULT '',
  `news_meta_robots` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
