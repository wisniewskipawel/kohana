<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Request extends Kohana_Request {
	
	protected $_referrer_route_name = NULL;

	/**
	 * @var  string  request Subdomain
	 */
	public static $subdomain ;

	public static function factory($uri = TRUE, $client_params = array(), $allow_external = TRUE, $injected_routes = array())
	{
		self::$subdomain = Request::catch_subdomain() ;

		return parent::factory($uri, $client_params, $allow_external, $injected_routes);
	}

	public static function catch_subdomain($base_url = NULL, $host = NULL) 
	{
		if($base_url === NULL) 
		{
			$base_url = parse_url(Kohana::$base_url, PHP_URL_HOST) ;
		}

		if($host === NULL) 
		{
			if(PHP_SAPI == 'cli') 
			{
				return FALSE ;
			}

			$host = $_SERVER['HTTP_HOST'] ;
		}

		if(empty($base_url) || empty($host) || in_array($host, Route::$localhosts) || Valid::ip($host)) 
		{
			return FALSE ;
		}

		$sub_pos = (int)strpos($host, $base_url) - 1 ;

		if($sub_pos > 0) 
		{
			$subdomain = substr($host,0,$sub_pos) ;

			if( !empty($subdomain) ) 
			{
				return $subdomain ;
			}
		}

		return '';
	}
	
	public function referrer_route_name()
	{
		if($this->_referrer_route_name !== NULL)
		{
			return $this->_referrer_route_name;
		}
		
		$referrer = new Request($this->_get_referrer_uri());
		
		if($referrer)
		{
			$routes = Route::all();

			foreach($routes as $route_name => $route)
			{
				if($route->matches($referrer))
				{
					return $this->_referrer_route_name = $route_name;
				}
			}
		}
		
		return $this->_referrer_route_name = FALSE;
	}
	
	private function _get_referrer_uri()
	{
		$referrer = $this->referrer();
		
		if(!$referrer)
		{
			return NULL;
		}
		
		$referrer = parse_url($referrer, PHP_URL_PATH);
		
		$base_url = parse_url(Kohana::$base_url, PHP_URL_PATH);

		if (strpos($referrer, $base_url) === 0)
		{
			// Remove the base URL from the URI
			$referrer = (string) substr($referrer, strlen($base_url));
		}
		
		return $referrer;
	}
	
}