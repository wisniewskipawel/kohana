<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Akosoft_Config_Writer extends Akosoft_Config_Reader implements Kohana_Config_Writer {
	
	public function write($group, $key, $config)
	{
		if (is_array($config))
		{
			$config = $this->_prepare_config($group, $key, $config);
			foreach ($config as $config_group) {
				$this->_save($config_group['config_group_name'], $config_group['config_key'], $config_group['config_value']);
			}
		} 
		else 
		{
			$config = serialize($config);
			$this->_save($group, $key, $config);
		}
		
		$this->_clear_cache();
		
		return TRUE;
	}
	
	protected function _prepare_config($config_group_name, $config_key, $config, array & $prepared_config = array())
	{
		foreach ($config as $key => $value) {
			if (is_array($config[$key])) {
				$this->_prepare_config($config_group_name . '.' . $config_key, $key, $config[$key], $prepared_config);
			} else {
				$prepared_config[] = array('config_group_name' => $config_group_name . '.' . $config_key, 'config_key' => $key, 'config_value' => serialize($value));
			}
		}
		
		return $prepared_config;
	}
	
	public function _save($group, $key, $config)
	{
		try 
		{
			$this->_update($group, $key, $config);
		}
		catch (Exception $e) 
		{
			$this->_insert($group, $key, $config);
		}
	}

	protected function _insert($group, $key, $config)
	{
		DB::insert($this->_table_name, array('config_group_name', 'config_key', 'config_value'))
				->values(array($group, $key, $config))
				->execute($this->_db_instance);

		return $this;
	}

	protected function _update($group, $key, $config) 
	{   
		$result = DB::select()
				->from($this->_table_name)
				->where('config_group_name', '=', $group)
				->where('config_key', '=', $key)
				->execute($this->_db_instance);
		
		if ( ! $result->count()) {
			throw new Exception;
		}
		
		DB::update($this->_table_name)
				->set(array('config_value' => $config))
				->where('config_group_name', '=', $group)
				->where('config_key', '=', $key)
				->execute($this->_db_instance);
		
		return $this;
	}
	
	public function delete_group($group_name)
	{
		DB::delete($this->_table_name)
				->where('config_group_name', '=', $group_name)
				->execute($this->_db_instance);
		
		$this->_clear_cache();
		
		return $this;
	}
}
