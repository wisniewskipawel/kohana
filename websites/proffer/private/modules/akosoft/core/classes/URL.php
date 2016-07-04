<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

class URL extends Kohana_URL {
	
	public static function base($protocol = NULL, $index = FALSE, $subdomain = NULL)
	{
		// Start with the configured base URL
		$base_url = parse_url(Kohana::$base_url, PHP_URL_PATH);

		if ($protocol === TRUE)
		{
			// Use the initial request to get the protocol
			$protocol = Request::$initial;
		}

		if ($protocol instanceof Request)
		{
			if ( ! $protocol->secure())
			{
				// Use the current protocol
				list($protocol) = explode('/', strtolower($protocol->protocol()));
			}
			else
			{
				$protocol = 'https';
			}
		}

		if ( ! $protocol)
		{
			// Use the configured default protocol
			$protocol = parse_url($base_url, PHP_URL_SCHEME);
		}

		if ($index === TRUE AND ! empty(Kohana::$index_file))
		{
			// Add the index file to the URL
			$base_url .= Kohana::$index_file.'/';
		}

		if (is_string($protocol))
		{
			if ($port = parse_url($base_url, PHP_URL_PORT))
			{
				// Found a port, make it usable for the URL
				$port = ':'.$port;
			}

			if ($domain = parse_url($base_url, PHP_URL_HOST))
			{
				// Remove everything but the path from the URL
				$base_url = parse_url($base_url, PHP_URL_PATH);
			}
			else
			{
				$domain = parse_url(Kohana::$base_url, PHP_URL_HOST);
			}
			
			if($subdomain)
			{
				$domain = $subdomain.'.'.$domain;
			}

			// Add the protocol and domain to the base URL
			$base_url = $protocol.'://'.$domain.$port.$base_url;
		}

		return $base_url;
	}

	public static function site($uri = '', $protocol = NULL, $index = TRUE, $subdomain = NULL)
	{
		if(stripos($uri, '://') !== FALSE)
		{
			return $uri;
		}
		
		$uri = trim($uri, '/');
		
		if ( ! UTF8::is_ascii($uri))
		{
			// Encode all non-ASCII characters, as per RFC 1738
			$uri = preg_replace_callback('~([^/]+)~', 'URL::_rawurlencode_callback', $uri);
		}

		// Concat the URL
		return URL::base($protocol, $index, $subdomain).$uri;
	}

	public static function title($title, $separator = '-', $ascii_only = FALSE)
	{
		return parent::title($title, $separator, TRUE);
	}
	
	public static function idna_encode($value)
	{
		require_once Kohana::find_file('vendor/idna_convert', 'idna_convert.class');
		
		$idna = new idna_convert();
		return $idna->encode($value);
	}
	
	public static function idna_decode($value)
	{
		require_once Kohana::find_file('vendor/idna_convert', 'idna_convert.class');
		
		$idna = new idna_convert();
		return $idna->decode($value);
	}
	
}
