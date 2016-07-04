<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

namespace AkoSoft\Updates;

abstract class Update {

	/**
	 * @var Database
	 */
	protected $db;

	/**
	 * @var Output
	 */
	protected $output;

	/**
	 * @var UpdateModule[]
	 */
	protected $updates;

	/**
	 * Update constructor.
	 * @param Database $database
	 * @param Output $output
	 */
	public function __construct(Database $database, Output $output)
	{
		$this->db = $database;
		$this->output = $output;
		$iterator = new \GlobIterator(DOCROOT.'private/modules/akosoft/*/config.php');

		foreach($iterator as $module_config_file)
		{
			if($module_config_file->isFile())
			{
				$module_config = include $module_config_file;

				if($module_config AND is_array($module_config) AND isset($module_config['namespace']))
				{
					$namespace = $module_config['namespace'];

					if(strpos($namespace, '\\') === FALSE)
					{
						$namespace = 'AkoSoft\\Modules\\' . ucfirst($namespace) . '\\';
					}

					$namespace .= 'Updates\\';
					$class_name = explode('\\', get_called_class());
					$class_name = $class_name[count($class_name)-1];
					$update_file = $module_config_file->getPathinfo() . '/updates/' . $class_name . '.php';

					if(file_exists($update_file))
					{
						require_once $update_file;

						$class_name = $namespace . $class_name;

						if(class_exists($class_name))
						{
							$update = new $class_name($module_config, $this->db, $this->output);
							if($update instanceof UpdateModule)
							{
								$this->updates[] = $update;
							}
						}
					}
				}
			}
		}
	}

	public function install()
	{
		foreach($this->updates as $update)
		{
			$this->output->write(sprintf('Updating module: %s', $update->get_name()));
			$update->install();
		}
	}

	public function post_install()
	{
		foreach($this->updates as $update)
		{
			$update->post_install();
		}
	}

	abstract public function get_name();

}