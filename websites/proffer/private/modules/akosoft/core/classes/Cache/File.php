<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Cache_File extends Kohana_Cache_File {

	/**
	 * Retrieve a cached value entry by id.
	 *
	 *     // Retrieve cache entry from file group
	 *     $data = Cache::instance('file')->get('foo');
	 *
	 *     // Retrieve cache entry from file group and return 'bar' if miss
	 *     $data = Cache::instance('file')->get('foo', 'bar');
	 *
	 * @param   string   $id       id of cache to entry
	 * @param   string   $default  default value to return if cache miss
	 * @return  mixed
	 * @throws  Cache_Exception
	 */
	public function get($id, $default = NULL)
	{
		$filename = Cache_File::filename($this->_sanitize_id($id));
		$directory = $this->_resolve_directory($filename);

		// Wrap operations in try/catch to handle notices
		try
		{
			// Open file
			$file = new SplFileInfo($directory.$filename);

			// If file does not exist
			if ( ! $file->isFile())
			{
				// Return default value
				return $default;
			}
			else
			{
				// Open the file and parse data
				$created  = $file->getMTime();
				$data     = $file->openFile();
				
				if($data->flock(LOCK_EX))
				{
					$lifetime = (int) $data->fgets();

					// If we're at the EOF at this point, corrupted!
					if ($data->eof())
					{
						// Delete the file
						$this->_delete_file($file, NULL, TRUE);
						return $default;
					}

					$cache = '';

					while ($data->eof() === FALSE)
					{
						$cache .= $data->fgets();
					}

					// Test the expiry
					if (($lifetime !== 0) AND (($created + $lifetime) < time()))
					{
						// Delete the file
						$this->_delete_file($file, NULL, TRUE);
						return $default;
					}
					else
					{
						return unserialize($cache);
					}
					
					$data->flock(LOCK_UN);
				}
				else
				{
					throw new Cache_Exception(__METHOD__.' failed to lock cache file.');
				}
			}

		}
		catch (ErrorException $e)
		{
			// Handle ErrorException caused by failed unserialization
			if ($e->getCode() === E_NOTICE)
			{
				throw new Cache_Exception(__METHOD__.' failed to unserialize cached object with message : '.$e->getMessage());
			}

			// Otherwise throw the exception
			throw $e;
		}
	}
	
	/**
	 * Set a value to cache with id and lifetime
	 *
	 *     $data = 'bar';
	 *
	 *     // Set 'bar' to 'foo' in file group, using default expiry
	 *     Cache::instance('file')->set('foo', $data);
	 *
	 *     // Set 'bar' to 'foo' in file group for 30 seconds
	 *     Cache::instance('file')->set('foo', $data, 30);
	 *
	 * @param   string   $id        id of cache entry
	 * @param   string   $data      data to set to cache
	 * @param   integer  $lifetime  lifetime in seconds
	 * @return  boolean
	 */
	public function set($id, $data, $lifetime = NULL)
	{
		$filename = Cache_File::filename($this->_sanitize_id($id));
		$directory = $this->_resolve_directory($filename);

		// If lifetime is NULL
		if ($lifetime === NULL)
		{
			// Set to the default expiry
			$lifetime = Arr::get($this->_config, 'default_expire', Cache::DEFAULT_EXPIRE);
		}

		// Open directory
		$dir = new SplFileInfo($directory);

		// If the directory path is not a directory
		if ( ! $dir->isDir())
		{
			$this->_make_directory($directory, 0777, TRUE);
		}

		// Open file to inspect
		$resouce = new SplFileInfo($directory.$filename);
		$file = $resouce->openFile('w');
		
		if($file->flock(LOCK_EX))
		{
			try
			{
				$data = $lifetime."\n".serialize($data);
				$file->fwrite($data, strlen($data));
				return (bool) $file->fflush();
			}
			catch (ErrorException $e)
			{
				// If serialize through an error exception
				if ($e->getCode() === E_NOTICE)
				{
					// Throw a caching error
					throw new Cache_Exception(__METHOD__.' failed to serialize data for caching with message : '.$e->getMessage());
				}

				// Else rethrow the error exception
				throw $e;
			}
			
			$file->flock(LOCK_UN);
		}
		else
		{
			throw new Cache_Exception(__METHOD__.' failed to lock cache file.');
		}
	}
	
}
