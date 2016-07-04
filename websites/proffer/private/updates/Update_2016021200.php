<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

namespace AkoSoft\Updates;

class Update_2016021200 extends Update {

	public function install()
	{
		$this->output->write('Change images table...');

		if(!$this->db->check_column_exists('images', 'extension'))
		{
			$this->db->query("ALTER TABLE `images` ADD `extension` VARCHAR(4) NULL DEFAULT NULL AFTER `image_description`");
		}

		$this->db->query("UPDATE `images` SET `extension`='png' WHERE `extension` IS NULL");

		parent::install();
	}

	public function get_name()
	{
		return 2016021200;
	}

}