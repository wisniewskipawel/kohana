<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Akosoft_Config_Reader implements Kohana_Config_Reader {

	protected $_db_instance = 'default';
	protected $_table_name  = 'config';
	protected $_loaded_config = array();
	protected $_inited = FALSE;
	protected $_cache = NULL;

	public function __construct(array $config = NULL)
	{
		if (isset($config['instance']))
		{
			$this->_db_instance = $config['instance'];
		}

		if (isset($config['table_name']))
		{
			$this->_table_name = $config['table_name'];
		}
		
		if(isset($config['cache']))
		{
			if(!$config['cache'] instanceof Cache)
			{
				$config['cache'] = Cache::instance($config['cache']);
			}
			
			$this->_cache = $config['cache'];
		}
	}

	public function load($group) 
	{
		if($group === 'database')
			return FALSE;
		
		$this->_init();

		return Arr::path($this->_loaded_config, $group, NULL, '.');
	}

	protected function _init() 
	{
		if ($this->_inited)
		{
			return;
		}
		
		if($this->_cache)
		{
			$this->_loaded_config = $this->_cache->get('config_db');
		}
		
		if(!$this->_loaded_config)
		{
			$query = DB::select('config_group_name', 'config_key', 'config_value')
					->from($this->_table_name)
					->order_by('config_group_name', 'ASC')
					->order_by('config_key', 'ASC')
					->execute($this->_db_instance);

			$result = $query->as_array();

			foreach ($result as $r)
			{
				$config_path = $r['config_group_name'].'.'.$r['config_key'];

				try
				{
					$unserialized = unserialize($r['config_value']);
				} 
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, '(bconfig) Error while unserializing value for config path: ":config_path". Error message: :error', array(
						':config_path' => $config_path,
						':error' => Kohana_Exception::text($ex),
					));

					Kohana_Exception::log($ex, Log::ERROR);

					continue;
				}

				Arr::set_path($this->_loaded_config, $config_path, $unserialized, '.');
			}
			
			if($this->_cache)
			{
				$this->_cache->set('config_db', $this->_loaded_config);
			}
		}
		
		$this->_inited = TRUE;
	}
	
	protected function _clear_cache()
	{
		if($this->_cache)
		{
			$this->_cache->delete('config_db');
		}
	}
	
}
