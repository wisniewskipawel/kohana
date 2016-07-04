<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_URL extends Bform_Validator_Regex {
	
	const REGEX_URL = '~^
		((http|https|ftp|ftps)://)?                # protocol
		(
		([a-z0-9-]+\.)+[a-z]{2,6}               # a domain name
		  |                                     #  or
		\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
		)
		(:[0-9]+)?                              # a port (optional)
		(/?|/\S+)                               # a /, nothing or a / with something
		$~ix';

	public function __construct(Bform_Driver_Common $driver, array $options = array()) 
	{
		$options['regex'] = isset($options['with_protocol']) ? '~^
		(http|https|ftp|ftps)://                # protocol
		(
		([a-z0-9-]+\.)+[a-z]{2,6}               # a domain name
		  |                                     #  or
		\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
		)
		(:[0-9]+)?                              # a port (optional)
		(/?|/\S+)                               # a /, nothing or a / with something
		$~ix' : self::REGEX_URL;
		$options['error'] = 'bform.validator.url';
		
		parent::__construct($driver, $options);
	}

}
