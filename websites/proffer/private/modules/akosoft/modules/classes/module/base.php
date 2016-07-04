<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
abstract class Module_Base {

	protected $_name = '';
	protected $_config = NULL;

	public function __construct($module_name, $config = NULL)
	{
		$this->_name = $module_name;
		$this->_config = Arr::merge($this->_load_config(), (array)$config);
	}
	
	public function get_name()
	{
		return $this->_name;
	}

	public function get_path()
	{
		return MODPATH . 'akosoft' . DIRECTORY_SEPARATOR . $this->get_name() . DIRECTORY_SEPARATOR;
	}
	
	public function on_initialize()
	{
		
	}
	
	public function routes()
	{
		return FALSE;
	}
	
	protected function _load_config()
	{
		if(file_exists($this->get_path().'config.php'))
		{
			return include $this->get_path().'config.php';
		}
		
		return array();
	}
	
	public function is_enabled()
	{
		return Modules::enabled($this->get_name());
	}
	
	public function is_installed()
	{
		return TRUE;
	}
	
}
