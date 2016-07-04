<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl 
* @copyright	Copyright (c) 2012, AkoSoft
*/
class Kohana extends Kohana_Core {
	
	const DEMO     = 15;
	
	protected static $_paths = array(APPPATH, AKOSOFT_PATH, SYSPATH);
	
	protected static $_modules_grouped = array();
	
	public static $autoloader = NULL;
	
	public static function init(array $settings = NULL)
	{
		if (Kohana::$_init)
		{
			// Do not allow execution twice
			return;
		}

		// Kohana is now initialized
		Kohana::$_init = TRUE;

		if (isset($settings['profile']))
		{
			// Enable profiling
			Kohana::$profiling = (bool) $settings['profile'];
		}

		// Start an output buffer
		ob_start();

		if (isset($settings['errors']))
		{
			// Enable error handling
			Kohana::$errors = (bool) $settings['errors'];
		}

		if (Kohana::$errors === TRUE)
		{
			// Enable Kohana exception handling, adds stack traces and error source.
			set_exception_handler(array('Kohana_Exception', 'handler'));

			// Enable Kohana error handling, converts all PHP errors to exceptions.
			set_error_handler(array('Kohana', 'error_handler'));
		}

		/**
		 * Enable xdebug parameter collection in development mode to improve fatal stack traces.
		 */
		if (Kohana::$environment == Kohana::DEVELOPMENT AND extension_loaded('xdebug'))
		{
		    ini_set('xdebug.collect_params', 3);
		}

		// Enable the Kohana shutdown handler, which catches E_FATAL errors.
		register_shutdown_function(array('Kohana', 'shutdown_handler'));

		if (ini_get('register_globals'))
		{
			// Reverse the effects of register_globals
			Kohana::globals();
		}

		if (isset($settings['expose']))
		{
			Kohana::$expose = (bool) $settings['expose'];
		}

		// Determine if we are running in a Windows environment
		Kohana::$is_windows = (DIRECTORY_SEPARATOR === '\\');

		// Determine if we are running in safe mode
		Kohana::$safe_mode = (bool) ini_get('safe_mode');

		if (isset($settings['cache_dir']))
		{
			if ( ! is_dir($settings['cache_dir']))
			{
				try
				{
					// Create the cache directory
					mkdir($settings['cache_dir'], 0755, TRUE);

					// Set permissions (must be manually set to fix umask issues)
					chmod($settings['cache_dir'], 0755);
				}
				catch (Exception $e)
				{
					throw new Kohana_Exception('Could not create cache directory :dir',
						array(':dir' => Debug::path($settings['cache_dir'])));
				}
			}

			// Set the cache directory path
			Kohana::$cache_dir = realpath($settings['cache_dir']);
		}
		else
		{
			// Use the default cache directory
			Kohana::$cache_dir = APPPATH.'cache';
		}

		if ( ! is_writable(Kohana::$cache_dir))
		{
			throw new Kohana_Exception('Directory :dir must be writable',
				array(':dir' => Debug::path(Kohana::$cache_dir)));
		}

		if (isset($settings['cache_life']))
		{
			// Set the default cache lifetime
			Kohana::$cache_life = (int) $settings['cache_life'];
		}

		if (isset($settings['caching']))
		{
			// Enable or disable internal caching
			Kohana::$caching = (bool) $settings['caching'];
		}

		if (Kohana::$caching === TRUE)
		{
			// Load the file path cache
			Kohana::$_files = Kohana::cache('Kohana::find_file()');
		}

		if (isset($settings['charset']))
		{
			// Set the system character set
			Kohana::$charset = strtolower($settings['charset']);
		}

		if (function_exists('mb_internal_encoding'))
		{
			// Set the MB extension encoding to the same character set
			mb_internal_encoding(Kohana::$charset);
		}

		if (isset($settings['base_url']))
		{
			// Set the base URL
			Kohana::$base_url = rtrim($settings['base_url'], '/').'/';
		}

		if (isset($settings['index_file']))
		{
			// Set the index file
			Kohana::$index_file = trim($settings['index_file'], '/');
		}

		// Determine if the extremely evil magic quotes are enabled
		Kohana::$magic_quotes = (version_compare(PHP_VERSION, '5.4') < 0 AND get_magic_quotes_gpc());

		// Sanitize all request variables
		$_GET    = Kohana::sanitize($_GET);
		$_POST   = Kohana::sanitize($_POST);
		$_COOKIE = Kohana::sanitize($_COOKIE);

		// Load the logger if one doesn't already exist
		if ( ! Kohana::$log instanceof Log)
		{
			Kohana::$log = Log::instance();
		}

		// Load the config if one doesn't already exist
		if ( ! Kohana::$config instanceof Config)
		{
			Kohana::$config = new Config;
		}
		
		Kohana::$_modules_grouped['init'] = array();
		Kohana::$_modules_grouped['templates'] = array();
		Kohana::$_modules_grouped['site_modules'] = array();
		Kohana::$_modules_grouped['modules'] = array();
		Kohana::$_modules_grouped['helpers'] = array();
	}
	
	public static function add_modules($group_name, $modules, $init = TRUE)
	{
		if(!isset(Kohana::$_modules_grouped[$group_name]))
		{
			Kohana::$_modules_grouped[$group_name] = array();
		}
		
		foreach ($modules as $name => $path)
		{
			if (is_dir($path))
			{
				Kohana::$_modules_grouped[$group_name][$name] = $modules[$name] = realpath($path).DIRECTORY_SEPARATOR;
			}
			else
			{
				// This module is invalid, remove it
				throw new Kohana_Exception('Attempted to load an invalid or missing module \':module\' at \':path\'', array(
					':module' => $name,
					':path'   => Debug::path($path),
				));
			}
		}
		
		self::reload_modules();
		
		if($init)
		{
			self::init_modules($modules);
		}
		
		return Kohana::$_modules;
	}
	
	public static function reload_modules()
	{
		Kohana::$_modules = Kohana::$_paths = array();
		
		Kohana::$_paths[] = APPPATH;
		Kohana::$_paths[] = AKOSOFT_PATH;
			
		foreach(Kohana::$_modules_grouped as $group_name => $modules_grouped)
		{
			foreach($modules_grouped as $name => $path)
			{
				Kohana::$_modules[$name] = $path;
				Kohana::$_paths[] = $path;
			}
		}
		
		Kohana::$_paths[] = SYSPATH;
	}

	public static function init_modules($modules)
	{
		foreach ($modules as $path)
		{
			$init = $path.'init'.EXT;

			if (is_file($init))
			{
				// Include the module initialization file once
				require_once $init;
			}
		}
	}

	public static function modules(array $modules = NULL)
	{
		if ($modules === NULL)
		{
			// Not changing modules, just return the current set
			return Kohana::$_modules;
		}

		return Kohana::add_modules('modules', $modules);
	}
	
}
