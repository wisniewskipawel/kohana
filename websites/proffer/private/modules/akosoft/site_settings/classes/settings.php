<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class settings {

	public static function bool($value)
	{
		if ($value)
		{
			return 'true';
		}
		return 'false';
	}

}
