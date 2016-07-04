<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Newsletter extends Controller_Cron_Main {
	
	public function action_send()
	{
		$queue = ORM::factory('Newsletter_Queue')->to_send(20);
		
		foreach ($queue as $q)
		{
			$message = $q->letter->letter_message;
			$message = str_replace('%unsubscribe%', HTML::anchor(Route::url('site_newsletter/frontend/unsubscibe', array(
				'id' => $q->subscriber->pk(),
				'token' => $q->subscriber->email_token,
			), 'http'), ___('newsletter.unsubscribe_btn')), $message);
			
			Email::send($q->subscriber->email, $q->letter->letter_subject, $message);
			$q->subscriber->increase_sended(1);
			$q->delete();
			sleep(0.5);
		}
	}
	
}
