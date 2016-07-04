<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Newsletter {
	
	public static function subscribe($email, $accept_ads = FALSE, $quiet = FALSE)
	{
		if(Valid::not_empty($email) AND Valid::email($email))
		{
			$result = ORM::factory('Newsletter_Subscriber')->add_email($email, $accept_ads);
			
			if($result AND !$quiet AND $accept_ads)
			{
				if($submit_text = Kohana::$config->load('modules.site_newsletter.settings.submit_text'))
				{
					FlashInfo::add(nl2br($submit_text), FlashInfo::INFO);
				}
			}
			
			return $result;
		}
		
		return FALSE;
	}
	
}
