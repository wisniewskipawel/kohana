<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Helper {

	/**
	 * Get array diff from array of objects
	 * 
	 * @param array $array1
	 * @param array $array2
	 * @return array 
	 */
	public static function array_diff_object(array $array1, array $array2) 
	{    
		foreach ($array1 as $key => $value) 
		{
			$array1[$key] = serialize($value);
		}
		foreach ($array2 as $key => $value) 
		{
			$array2[$key] = serialize($value);
		}

		$array_diff = array_diff($array1, $array2);

		foreach ($array_diff as $key => $value) 
		{
			$array_diff[$key] = unserialize($value);
		}

		return $array_diff;
	}

	/**
	 * Check if object exists in array
	 * 
	 * @param type $function_name Method name - returned value is compared
	 * @param type $object Object to check
	 * @param array $array Array of objects
	 * @return type 
	 */
	public static function in_array($function_name, & $object, array & $array) 
	{
		foreach ($array as $item) 
		{
			if ($item->$function_name() == $object->$function_name()) 
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * Check if objects are equal
	 * 
	 * @param type $obj1
	 * @param type $obj2
	 * @return bool
	 */
	public static function objects_equal($obj1, $obj2) 
	{
		return (serialize($obj1) == serialize($obj2));
	}

	public static function name_from_path($path)
	{
		$path = trim($path, '.');
		
		if(strpos($path, '.') !== FALSE)
		{
			$path = preg_replace('#\.#', '[', $path, 1);
			$path = preg_replace('#\.#', '][', $path);
			$path .= ']';
		}
		
		return $path;
	}
	
}
