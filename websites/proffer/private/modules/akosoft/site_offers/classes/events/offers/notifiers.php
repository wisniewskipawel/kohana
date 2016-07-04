<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_Notifiers extends Events {
	
	public function on_menu()
	{
		return array(
			'route' => Route::get('site_notifier/notifier/offers'),
			'title' => ___('offers.notifier.title'),
		);
	}
	
	public function on_send()
	{
		$notifier = new Model_Notifier();
		$notifier->filter_by_active();
		$notifier->filter_by_module('site_offers');
		$users = $notifier->find_subscribers();
		
		Kohana::$log->add(Log::INFO, 'site_notifier: (CRON) Start send mailing to :count addresses. (module=:module)', array(
			':count' => count($users),
			':module' => 'site_offers',
		))->write();
		
		$i = 0;
		
		$model = new Model_Offer;
		
		foreach ($users as $notify_user)
		{
			$offers = $model->find_offers_for_notifier($notify_user);
			
			if ( ! count($offers))
			{
				continue;
			}
			
			$new_offers = array();
			foreach ($offers as $a)
			{
				$new_offers[$a->category_name][] = $a;
			}
			
			$email = ORM::factory('email')->find_by_alias('notifier_offers');
			
			$email_content = View::factory('emails/offers/notifier')
					->set('offers', $new_offers)
					->render();
			
			$email->set_tags(array(
				'%offers_links%'	=> $email_content,
				'%unsubscibe_link%'			=> HTML::anchor(Route::url('site_notifier/frontend/notifier/unsubscribe', array(
					'id'		=> $notify_user->pk(),
					'token'	=> $notify_user->token,
				), 'http'), ___('offers.email.notifier.unsubscribe')),
			));
			$email->send($notify_user->notify_email);
			
			$i++;
		}
		
		$model->mark_notified();
		
		Kohana::$log->add(Log::INFO, 'site_notifier: (CRON) Stop mailing. (count=:count)', array(
			':count' => $i,
		))->write();
		
		return $i;
	}
	
}
