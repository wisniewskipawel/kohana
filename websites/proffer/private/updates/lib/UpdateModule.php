<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

namespace AkoSoft\Updates;

abstract class UpdateModule {

	/**
	 * @var array
	 */
	protected $module_config;

	/**
	 * @var Database
	 */
	protected $db;

	/**
	 * @var Output
	 */
	protected $output;

	/**
	 * UpdateModule constructor.
	 * @param array $module_config
	 * @param Database $database
	 * @param Output $output
	 */
	public function __construct(array $module_config, Database $database, Output $output)
	{
		$this->module_config = $module_config;
		$this->db = $database;
		$this->output = $output;
	}

	public function install()
	{

	}

	public function post_install()
	{

	}

	public function get_name()
	{
		return $this->module_config['name'];
	}

}