<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

namespace AkoSoft\Updates;

include 'Update.php';
include 'UpdateModule.php';
include 'Database.php';
include 'Output.php';

class UpdateManager {

	/**
	 * @var Database
	 */
	protected $db;

	/**
	 * @var Output
	 */
	protected $output;

	/**
	 * @var mixed|null
	 */
	protected $installed_update = NULL;

	/**
	 * UpdateManager constructor.
	 * @param Output $output
	 */
	public function __construct(Output $output)
	{
		$this->db = new Database();
		$this->output = $output;

		$installed = $this->db->select_one("SELECT config_value FROM config WHERE config_group_name='update' AND config_key='installed';", 'config_value');

		if($installed)
		{
			$this->installed_update = unserialize($installed);
		}
	}

	public function execute()
	{
		$updates = $this->find_updates_to_install();

		foreach($updates as $update_name => $update)
		{
			$this->do_install($update);

			require_once APPPATH.'bootstrap.php';

			$this->do_clean();

			$this->do_post_install($update);

			$this->make_update_installed($update);

			$this->output->write('Done installing updates');
			break;
		}
	}

	public function do_install(Update $update)
	{
		$this->output->write(sprintf('Installing update: %s', $update->get_name()));
		$update->install();
	}

	public function do_post_install(Update $update)
	{
		$this->output->write(sprintf('Running post-install: %s', $update->get_name()));
		$update->post_install();
	}

	public function do_clean()
	{
		$this->output->write('Cleaning...');

		\Media::clear_compiled();
		\Cache::instance()->delete_all();
	}

	/**
	 * @return Update[]
	 */
	protected function find_updates_to_install()
	{
		$to_install = array();
		$iterator = new \DirectoryIterator(DOCROOT.'private/updates');
		foreach($iterator as $item)
		{
			if($item->isFile())
			{
				require_once $item->getRealPath();

				$class_name = 'AkoSoft\\Updates\\'.str_replace(EXT, '', $item->getFilename());
				$update = new $class_name($this->db, $this->output);
				if($update instanceof Update)
				{
					if(!$this->is_update_installed($update))
					{
						$to_install[$update->get_name()] = $update;
					}
				}
			}
		}

		if(!empty($to_install))
		{
			ksort($to_install);
		}

		return $to_install;
	}

	/**
	 * @param Update $update
	 * @return bool
	 */
	protected function is_update_installed(Update $update)
	{
		return $this->installed_update >= $update->get_name();
	}

	/**
	 * @param Update $update
	 */
	protected function make_update_installed(Update $update)
	{
		if($this->installed_update)
		{
			$this->db->query("UPDATE `config` SET `config_value`='".$this->db->escape(serialize($update->get_name()))."' WHERE `config_group_name`='update' AND `config_key`='installed'");
			$this->db->query("UPDATE `config` SET `config_value`='".$this->db->escape(serialize(time()))."' WHERE `config_group_name`='update' AND `config_key`='timestamp'");
		}
		else
		{
			$this->db->insert('config', array(
				'config_group_name' => 'update',
				'config_key' => 'installed',
				'config_value' => serialize($update->get_name()),
			));

			$this->db->insert('config', array(
				'config_group_name' => 'update',
				'config_key' => 'timestamp',
				'config_value' => serialize(time()),
			));
		}
	}



}