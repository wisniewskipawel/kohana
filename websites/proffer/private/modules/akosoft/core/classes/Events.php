<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events extends Event_Module {
	
	protected static $_listeners = array();

	public static function factory($class_prefix, $module = NULL)
	{
		$class_name = 'Events_' . ucfirst($class_prefix);
		
		if(!class_exists($class_name))
			return FALSE;
		
		return ($module AND $module != 'app') ? new $class_name($module) : new $class_name();
	}
	
	public static function add_listener($event_name, $callable, $ordering = 0)
	{
		if(!is_array($callable))
		{
			throw new InvalidArgumentException('Invalid callable argument!');
		}
		
		static::$_listeners[$event_name][] = array(
			'event_name' => $event_name,
			'callable' => $callable,
			'params' => array(),
			'ordering' => $ordering,
		);
	}
	
	public static function fire($event_name, $event_params = NULL, $result_array = FALSE)
	{
		$cache_key = $event_name.URL::query($event_params, FALSE);
		
		$profiler_token = Profiler::start('Events', $cache_key);
		$modules = NULL;
		
		try
		{
			$modules = Kohana::cache($cache_key);
		}
		catch(Cache_Exception $ex)
		{
			Kohana_Exception::log($ex, Log::WARNING);
		}
		
		if($modules === NULL || Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$modules = self::_get_subscribers($event_name);
			
			Kohana::cache($cache_key, $modules, 43200);
		}
		
		$results = array();
		
		if($modules AND is_array($modules))
		{
			foreach($modules as $module)
			{
				$mptoken = Profiler::start('Events Exec', http_build_query($module));

				if(!$event_params)
					$event_params = array();

				if(isset($module['params']))
				{
					$event_params = array_merge($event_params, $module['params']);
				}

				if(isset($module['callable']))
				{
					$result = self::_handle_event_callable(
						$module['callable'],
						$event_params
					);
				}
				else
				{
					$result = self::_handle_event(
						$module['module_name'], 
						$module['event_name'], 
						$event_params
					);
				}

				if($result !== NULL)
				{
					$results[] = $result;
				}

				Profiler::stop($mptoken);
			}
		}
		
		Profiler::stop($profiler_token);
		
		return $result_array ? $results : implode("\n", $results);
	}
	
	protected static function _get_subscribers($event_name)
	{
		$slugify_event_name = str_replace('/', '_', $event_name);
		$events = Kohana::$config->load('events');

		$modules = (array)Arr::get(static::$_listeners, $event_name);
		
		if($app_event = Arr::path($events, 'app.on_'.$slugify_event_name))
		{
			$modules = array_merge($modules, self::_event_subscriber($event_name, 'app', $app_event));
		}

		$enabled_modules = Modules::instance()->enabled_modules();
		
		foreach($enabled_modules as $module_name => $module)
		{
			if($module instanceof Module_Future)
			{
				$module_slug = $module->get_slug();

				if($module_slug AND $module_events = Arr::get($events, $module_slug))
				{
					$init_handler = self::_init_handler_future($module, $event_name);

					if(!$init_handler)
						continue;

					list($event_class, $event_method) = $init_handler;

					$ordering = Arr::path($module_events, 'on_' .$slugify_event_name);

					$modules = array_merge($modules, self::_event_subscriber($event_name, $module->get_name(), $ordering));
				}
			}
			else
			{
				$namespace = $module->get_namespace();

				if($namespace AND $module_events = Arr::get($events, $namespace))
				{
					$init_handler = self::_init_handler($module, $event_name);

					if(!$init_handler)
						continue;

					list($event_class, $event_method) = $init_handler;

					$ordering = Arr::path($module_events, 'on_' .$slugify_event_name);

					$modules = array_merge($modules, self::_event_subscriber($event_name, $module_name, $ordering));
				}
			}
		}
		
		usort($modules, 'Events::_sort_module_component_actions');
		
		return $modules;
	}
	
	protected static function _event_subscriber($event_name, $module_name, $ordering)
	{
		$modules = array();
		
		$module_data = array(
			'module_name' => $module_name,
			'event_name' => $event_name,
			'params' => array(),
		);

		if(is_array($ordering))
		{
			foreach ($ordering as $subaction_name => $subaction_ordering)
			{
				if($subaction_ordering !== FALSE)
				{
					$module_data['params']['subaction_name'] = $subaction_name;
					$module_data['ordering'] = (int)$subaction_ordering;
					$modules[] = $module_data;
				}
			}
		}
		elseif($ordering !== FALSE)
		{
			$module_data['ordering'] = (int)$ordering;
			$modules[] = $module_data;
		}
		
		return $modules;
	}

	private static function _sort_module_component_actions($a, $b)
	{
		if ($a['ordering'] == $b['ordering'])
		{
			return 0;
		}
		
		return ($a['ordering'] < $b['ordering']) ? -1 : 1;
	}
	
	public static function fire_once($module_name, $event_name, $event_params = NULL)
	{
		if(empty($module_name))
		{
			return NULL;
		}
		
		if(!Modules::enabled($module_name))
		{
			Kohana::$log->add(Log::WARNING, 'Events: Module ":name" is not enabled! (event_name=:event_name)', array(
				':name' => $module_name,
				':event_name' => $event_name,
			));
			
			return;
		}
		
		$module = Modules::instance()->get($module_name);

		return self::_handle_event($module, $event_name, $event_params);
	}
	
	protected static function _init_handler_future(Module_Future $module, $event_name, $event_params = NULL)
	{
		$parts = explode('/', $event_name, 2);
		
		if(count($parts) < 2)
		{
			return FALSE;
		}
		
		$event_name = $parts[1];
		
		$event_class_name = $module->get_namespace().'Events\\'.ucfirst($parts[0]);
		
		if(!class_exists($event_class_name))
		{
			return FALSE;
		}
		
		$event_class = new $event_class_name($module);

		$event_name = 'on_'.str_replace('/', '_', $event_name);

		if (!method_exists($event_class, $event_name))
			return FALSE;
		
		if($event_params)
		{
			$event_class->params($event_params);
		}
		
		return array($event_class, $event_name);
	}
	
	protected static function _init_handler($module, $event_name, $event_params = NULL)
	{
		$class_name = NULL;
		
		if($module == 'app')
		{
			$class_name = 'app';
		}
		else
		{
			$class_name = $module->get_namespace();
		}
		
		$parts = explode('/', $event_name, 2);
		
		if(count($parts))
		{
			$class_name .= '_'.ucfirst($parts[0]);
			$event_name = $parts[1];
		}
		
		$event_class = Events::factory($class_name, $module);

		$event_name = 'on_'.str_replace('/', '_', $event_name);

		if (!method_exists($event_class, $event_name))
			return FALSE;
		
		if($event_params)
		{
			$event_class->params($event_params);
		}
		
		return array($event_class, $event_name);
	}
	
	protected static function _handle_event($module, $event_name, $event_params = NULL)
	{
		if(is_string($module) AND $module != 'app')
		{
			try
			{
				$module = Modules::instance()->get($module);
			}
			catch(Exception $ex)
			{
				return FALSE;
			}
		}
		
		if($module instanceof Module_Future)
		{
			$callable = self::_init_handler_future($module, $event_name);
		}
		else
		{
			$callable = self::_init_handler($module, $event_name);
		}

		if(!$callable)
			return FALSE;

		return self::_handle_event_callable($callable, $event_params);
	}
	
	protected static function _handle_event_callable($callable, $event_params = NULL)
	{
		list($event_class, $method_name) = $callable;
		
		if(!$event_class instanceof Event)
		{
			if(!class_exists($event_class))
				return FALSE;
			
			$event_class = new $event_class();
		}
		
		if($event_class)
		{
			$event_class->params($event_params);

			return $event_class->{$method_name}();
		}
		
		return FALSE;
	}
	
}