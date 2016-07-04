<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Security extends Kohana_Security {

	/**
	 * @var  HTMLPurifier  singleton instance of the HTML Purifier object
	 */
	protected static $htmlpurifier;

	/**
	 * @param string $text
	 * @return string
	 */
	public static function clean_text($text)
	{
		$text = UTF8::trim($text);
		//$text = HTML::entities($text, FALSE);
		$text = Security::xss_clean($text);
		
		return $text;
	}

	/**
	 * @param string $text
	 * @return string
	 */
	public static function escape_text($text)
	{
		return HTML::chars($text, FALSE);
	}

	/**
	 * @param $html_text
	 * @param null $config
	 * @return string
	 */
	public static function clean_html_text($html_text, $config = NULL)
	{
		$html_text = UTF8::trim($html_text);
		
		// Load HTML Purifier
		$purifier = Security::htmlpurifier($config);

		// Clean the HTML and return it
		return $purifier->purify(html_entity_decode($html_text));
	}
	
	/**
	 * Returns the singleton instance of HTML Purifier. If no instance has
	 * been created, a new instance will be created. Configuration options
	 * for HTML Purifier can be set in `APPPATH/config/purifier.php` in the
	 * "settings" key.
	 *
	 *	 $purifier = Security::htmlpurifier();
	 * 
	 * @param	HTMLPurifier_Config	$settings	configuration for purifier
	 * @return  HTMLPurifier
	 */
	public static function htmlpurifier($settings = NULL)
	{
		if ( ! Security::$htmlpurifier)
		{
			// Create a new configuration object
			$config = HTMLPurifier_Config::createDefault();

			if ( ! Kohana::$config->load('purifier.finalize'))
			{
				// Allow configuration to be modified
				$config->autoFinalize = FALSE;
			}

			// Use the same character set as Kohana
			$config->set('Core.Encoding', Kohana::$charset);

			
			if (is_array($settings))
			{
				//merge global and settings from param
				$settings = array_merge(Kohana::$config->load('purifier.settings'), $settings);
			}
			
			if(!$settings)
			{
				$settings = Kohana::$config->load('purifier.settings');
			}
				
			// Load the settings
			$config->loadArray($settings);

			// Configure additional options
			$config = Security::configure($config);

			// Create the purifier instance
			Security::$htmlpurifier = new HTMLPurifier($config);
		}

		return Security::$htmlpurifier;
	}

	/**
	 * Modifies the configuration before creating a HTML Purifier instance.
	 *
	 * [!!] You must create an extension and overload this method to use it.
	 *
	 * @param   HTMLPurifier_Config $config configuration object
	 * @return  HTMLPurifier_Config
	 */
	public static function configure(HTMLPurifier_Config $config)
	{
		return $config;
	}

	/** 
	 * Remove XSS from user input.
	 *
	 * @author	 Christian Stocker <chregu@bitflux.ch>
	 * @copyright  (c) 2001-2006 Bitflux GmbH
	 *
	 * @param   mixed	string or array to sanitize
	 * @return  string
	 */
	public static function xss_clean($str)
	{
		// http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
		// +----------------------------------------------------------------------+
		// | Copyright (c) 2001-2006 Bitflux GmbH								 |
		// +----------------------------------------------------------------------+
		// | Licensed under the Apache License, Version 2.0 (the "License");	  |
		// | you may not use this file except in compliance with the License.	 |
		// | You may obtain a copy of the License at							  |
		// | http://www.apache.org/licenses/LICENSE-2.0						   |
		// | Unless required by applicable law or agreed to in writing, software  |
		// | distributed under the License is distributed on an "AS IS" BASIS,	|
		// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or	  |
		// | implied. See the License for the specific language governing		 |
		// | permissions and limitations under the License.					   |
		// +----------------------------------------------------------------------+
		// | Author: Christian Stocker <chregu@bitflux.ch>						|
		// +----------------------------------------------------------------------+
		//
		// Kohana Modifications:
		// * Changed double quotes to single quotes, changed indenting and spacing
		// * Removed magic_quotes stuff
		// * Increased regex readability:
		//   * Used delimeters that aren't found in the pattern
		//   * Removed all unneeded escapes
		//   * Deleted U modifiers and swapped greediness where needed
		// * Increased regex speed:
		//   * Made capturing parentheses non-capturing where possible
		//   * Removed parentheses where possible
		//   * Split up alternation alternatives
		//   * Made some quantifiers possessive
		// * Handle arrays recursively

		if (is_array($str) OR is_object($str))
		{
			foreach ($str as $k => $s)
			{
				$str[$k] = Security::xss_clean($s);
			}

			return $str;
		}

		// Remove all NULL bytes
		$str = str_replace("\0", '', $str);

		// Fix &entity\n;
		$str = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $str);
		$str = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $str);
		$str = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $str);
		$str = html_entity_decode($str, ENT_COMPAT, Kohana::$charset);

		// Remove any attribute starting with "on" or xmlns
		$str = preg_replace('#(?:on[a-z]+|xmlns)\s*=\s*[\'"\x00-\x20]?[^\'>"]*[\'"\x00-\x20]?\s?#iu', '', $str);

		// Remove javascript: and vbscript: protocols
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $str);
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $str);
		$str = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $str);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
		$str = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#ius', '$1>', $str);

		// Remove namespaced elements (we do not need them)
		$str = preg_replace('#</*\w+:\w[^>]*+>#i', '', $str);

		do
		{
			// Remove really unwanted tags
			$old = $str;
			$str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
		}
		while ($old !== $str);

		return $str;
	}

}
