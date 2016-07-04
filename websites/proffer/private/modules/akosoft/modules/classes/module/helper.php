<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Module_Helper {

	public static function table_exists($table_name)
	{
		$databases = Kohana::$config->load('database');
		$databases = $databases->as_array();

		foreach ($databases as $name => $db_config)
		{
			if (empty($db_config['connection']['database']))
			{
				continue;
			}

			$database_name = $db_config['connection']['database'];

			$result = DB::select('table_name', 'table_schema')
					->from('information_schema.tables')
					->where('table_schema', '=', $database_name)
					->where('table_name', '=', $table_name)
					->execute($name, TRUE);

			if ($result->current())
			{
				return $name;
			}
		}
		return FALSE;
	}

}
