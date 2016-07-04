<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Route extends Kohana_Route {
	
	const SUBDOMAIN_WILDCARD = '*', SUBDOMAIN_EMPTY = '' ;

	public static $default_subdomains = array( self::SUBDOMAIN_EMPTY, 'www' ) ;
	
	protected static $_global_params = array();

	/**
	 * @param $params
	 */
	public static function set_global_params($params)
	{
		self::$_global_params = $params;
	}

	/**
	 * @param array|NULL $params
	 * @return mixed|string
	 */
	public function uri(array $params = NULL)
	{
		if(!$params)
		{
			$params = array();
		}
		
		$params = array_merge(self::$_global_params, $params);
		
		$uri = parent::uri($params);

		if(!empty($params['subdomain']))
		{
			if($params['subdomain'] == self::SUBDOMAIN_WILDCARD)
			{
				return URL::site($uri, TRUE, FALSE, Request::$subdomain);
			}

			return $uri;
		}
		else
		{
			if(Request::$subdomain)
			{
				return URL::site($uri, TRUE, FALSE, NULL);
			}
		}

		if($this->get_secure() === TRUE)
		{
			return URL::site($uri, 'https', FALSE, NULL);
		}
		else
		{
			return URL::site($uri, 'http', FALSE, NULL);
		}
	}

	/**
	 * @param Request $request
	 * @return array|bool
	 */
	public function matches(Request $request)
	{
		// Get the URI from the Request
		$uri = trim($request->uri(), '/');
		
		$subdomain = Request::catch_subdomain();

		if(empty($subdomain)) 
		{
			$subdomain = self::SUBDOMAIN_EMPTY;
		}
		
		if(isset($this->_defaults['subdomain']))
		{
			//allow subdomain.domain.com and domain.com
			if($this->_defaults['subdomain'] === TRUE)
			{
				return parent::matches($request);
			}
			
			if(($this->_defaults['subdomain'] == self::SUBDOMAIN_WILDCARD && !empty($subdomain))
				|| $this->_defaults['subdomain'] == $subdomain
				|| in_array($this->_defaults['subdomain'], self::$default_subdomains)
			)
			{
				return parent::matches($request);
			}
		}
		else
		{
			if($subdomain == self::SUBDOMAIN_EMPTY)
			{
				return parent::matches($request);
			}
		}

		return FALSE;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public static function exists($name)
	{
		return isset(Route::$_routes[$name]);
	}

	/**
	 * Stores a named route and returns it. The "action" will always be set to
	 * "index" if it is not defined.
	 *
	 *     Route::set('default', '(<controller>(/<action>(/<id>)))')
	 *         ->defaults(array(
	 *             'controller' => 'welcome',
	 *         ));
	 *
	 * @param   string  $name           route name
	 * @param   string  $uri_callback   URI pattern
	 * @param   array   $regex          regex patterns for route keys
	 * @return  Route
	 */
	public static function set($name, $uri_callback = NULL, $regex = NULL)
	{
		if($uri_callback === TRUE)
		{
			$uri_callback = ___($name);
		}
		
		return Route::$_routes[$name] = new Route($uri_callback, $regex);
	}

	/**
	 * @return mixed
	 */
	public function get_namespace()
	{
		return Arr::get($this->_defaults, 'namespace');
	}

	/**
	 * @return bool|null
	 */
	public function get_secure()
	{
		$secure = isset($this->_defaults['secure']) ? $this->_defaults['secure'] : NULL;

		return $secure AND Site::config('enable_https');
	}
	
}
