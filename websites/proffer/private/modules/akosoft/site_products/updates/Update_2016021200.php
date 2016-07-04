<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

namespace AkoSoft\Modules\Products\Updates;

use AkoSoft\Updates\UpdateModule;

class Update_2016021200 extends UpdateModule {

	public function install()
	{
		$this->output->write('Creating table product_categories...');

		$result = $this->db->query("CREATE TABLE IF NOT EXISTS `product_categories` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

		if($result AND !$this->db->is_table_not_empty('product_categories'))
		{
			$this->output->write('Inserting product_categories from catalog_categories...');


			$this->db->query('INSERT INTO `product_categories` SELECT * FROM `catalog_categories`;');
		}
	}

}
