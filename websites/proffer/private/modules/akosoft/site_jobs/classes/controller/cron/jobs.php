<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Cron_Jobs extends Controller_Cron_Main {
	
	public function action_expired()
	{
		$jobs = Model_Job::factory()->find_expired();
		
		foreach ($jobs as $job)
		{
			if ($job->has_user()) 
			{
				$email = Model_Email::email_by_alias('jobs.expired');
				
				$email->set_tags(array(
					'%job.title%' => HTML::chars($job->title),
					'%job.url%' => URL::site(Jobs::uri($job), 'http'),
					'%job.count_replies%' => (int)$job->count_replies,
				));
				
				$job->send_email_message($email);
			}
		}
		
		Model_Job::factory()->mark_expired();
	}
	
}
