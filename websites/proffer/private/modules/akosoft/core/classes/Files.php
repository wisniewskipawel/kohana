<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Files {
	
	public static function delete_directory($directory, $keep_directory = FALSE)
	{
		$files = new DirectoryIterator($directory);
		
		while ($files->valid())
		{
			$name = $files->getFilename();
			
			if ($name != '.' AND $name != '..')
			{
				$path = $files->getRealPath();

				if($files->isDir())
				{
					self::delete_directory($path);
				}
				else
				{
					try {
						unlink($path);
					} 
					catch(Exception $ex)
					{
						Kohana_Exception::log($ex, Log::WARNING);
					}
				}
			}
			
			$files->next();
		}
		
		if(!$keep_directory)
		{
			rmdir($directory);
		}
		
		return TRUE;
	}
	
}