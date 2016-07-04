<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Events_Jobs_Notifiers extends Events {

	public function on_menu()
	{
		return array(
			'route' => Route::get('site_notifier/notifier/jobs'),
			'title' => ___('jobs.notifier.title'),
		);
	}

	public function on_send()
	{
		$notifier = new Model_Notifier();
		$notifier->filter_by_active();
		$notifier->filter_by_module('site_jobs');
		$users = $notifier->find_subscribers();

		Kohana::$log->add(Log::INFO, 'site_notifier: (CRON) Start send mailing to :count addresses. (module=:module)', array(
			':count' => count($users),
			':module' => 'site_jobs',
		))->write();

		$i = 0;

		$model = new Model_Job;

		foreach($users as $notify_user)
		{
			$jobs = $model->find_jobs_for_notifier($notify_user);

			if(!count($jobs))
			{
				continue;
			}

			$new_jobs = array();
			foreach($jobs as $a)
			{
				$new_jobs[$a->category_name][] = $a;
			}

			$email = Model_Email::email_by_alias('jobs.notifier');

			if($email AND $email->loaded())
			{
				$email_content = View::factory('jobs/emails/notifier')
					->set('jobs', $new_jobs)
					->render();
				
				$unsubscribe_url = Route::url('site_notifier/frontend/notifier/unsubscribe', array(
					'id' => $notify_user->pk(),
					'token' => $notify_user->token,
				), 'http');

				$email->set_tags(array(
					'%jobs_links%' => $email_content,
					'%unsubscibe_url%' => $unsubscribe_url,
					'%unsubscibe_link%' => HTML::anchor($unsubscribe_url, ___('jobs.notifier.email.unsubscribe')),
				));
				
				$email->send($notify_user->notify_email);

				$i++;
			}
		}

		$model->mark_notified();

		Kohana::$log->add(Log::INFO, 'site_notifier: (CRON) Stop mailing. (count=:count)', array(
			':count' => $i,
		))->write();

		return $i;
	}

}
