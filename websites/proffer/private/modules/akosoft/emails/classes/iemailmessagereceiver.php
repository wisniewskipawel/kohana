<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
interface IEmailMessageReceiver {
	
	public function get_email_address();
	
	public function send_email_message($subject, $message = NULL, $params = NULL);
	
}