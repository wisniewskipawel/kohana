<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl 
* @copyright	Copyright (c) 2012, AkoSoft
*/
class Arr extends Kohana_Arr {
	
	public static function pluck($array, $key, $preserve_keys = FALSE)
	{
		$values = array();

		foreach ($array as $key_row => $row)
		{
			if (isset($row[$key]))
			{
				if($preserve_keys)
				{
					$values[$key_row] = $row[$key];
				}
				else
				{
					$values[] = $row[$key];
				}
			}
		}

		return $values;
	}
	
	public static function flatten($array, $preserve_keys = FALSE)
	{
		$is_assoc = $preserve_keys ? $preserve_keys : Arr::is_assoc($array);

		$flat = array();
		foreach ($array as $key => $value)
		{
			if (is_array($value))
			{
				$flat = $flat + Arr::flatten($value, $preserve_keys);
			}
			else
			{
				if ($is_assoc)
				{
					$flat[$key] = $value;
				}
				else
				{
					$flat[] = $value;
				}
			}
		}
		return $flat;
	}
	
	public static function set_path( & $array, $path, $value, $delimiter = NULL)
	{
		if ( ! $delimiter)
		{
			// Use the default delimiter
			$delimiter = Arr::$delimiter;
		}
		
		// Split the keys by delimiter
		$keys = explode($delimiter, $path);

		// Set current $array to inner-most array path
		while (count($keys) > 1)
		{
			$key = array_shift($keys);

			if (ctype_digit($key))
			{
				// Make the key an integer
				$key = (int) $key;
			}

			if ( ! isset($array[$key]) OR !is_array($array[$key]))
			{
				$array[$key] = array();
			}
			
			$array = & $array[$key];
			
		}
		
		// Set key on inner-most array
		$array[array_shift($keys)] = $value;
	}
	
}