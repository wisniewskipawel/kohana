<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Num extends Kohana_Num {
	
	public static function pretty_size($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
	{
		// Format string
		$format = ($format === NULL) ? '%01.2F %s' : (string) $format;

		// IEC prefixes (binary)
		if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
		{
			$units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
			$mod   = 1024;
		}
		// SI prefixes (decimal)
		else
		{
			$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
			$mod   = 1000;
		}

		// Determine unit to use
		if (($power = array_search((string) $force_unit, $units)) === FALSE)
		{
			$power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
		}

		return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
	}
	
}
