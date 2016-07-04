<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Jobs {
	
	protected static $_config = NULL;
	
	public static function config($key = NULL, $default = NULL)
	{
		if(self::$_config === NULL)
		{
			self::$_config = Arr::merge(
				(array)Kohana::$config->load('jobs'),
				(array)Kohana::$config->load('modules.site_jobs')
			);
		}
		
		if($key === NULL)
			return self::$_config;
		
		return Arr::path(self::$_config, $key, $default);
	}
	
	public static function url(Model_Job $job, $protocol = NULL)
	{
		return URL::site(self::uri($job), $protocol);
	}
	
	public static function uri(Model_Job $job)
	{
		$uri = Route::get('site_jobs/frontend/jobs/show')->uri(array(
			'id' => $job->pk(),
			'title' => URL::title($job->title),
		));
		
		return $uri;
	}

	/**
	 * @param Model_Job $job
	 * @param $place
	 * @param $title
	 * @return string
	 */
	public static function curtain(Model_Job $job, $place, $title)
	{
		return HTML::anchor(
			Route::url('ajax', array(
				'controller' => 'jobs',
				'action' => 'curtain',
				'id' => $job->pk(),
			), 'http').'?show='.$place,
			___($title),
			array(
				'class' => 'ajax_curtain',
				'rel' => 'nofollow',
			)
		);
	}

	/**
	 * @param Model_Job_Reply $reply
	 * @param $place
	 * @param $title
	 * @return string
	 */
	public static function curtain_reply(Model_Job_Reply $reply, $place, $title)
	{
		return HTML::anchor(
			Route::url('ajax', array(
				'controller' => 'jobs',
				'action' => 'curtain_reply',
				'id' => $reply->pk(),
			), 'http').'?show='.$place,
			$title,
			array(
				'class' => 'ajax_curtain',
				'rel' => 'nofollow',
			)
		);
	}
	
	public static function availabilites()
	{
		$availabilities = Model_Job_Availability::factory()
			->order_by('availability', 'ASC')
			->find_all();
		
		if(!count($availabilities))
			return NULL;
		
		$return = array();
		
		foreach($availabilities as $a)
		{
			$return[$a->availability] = ___('jobs.availability_span.days', $a->availability, array(':nb' => $a->availability));
		}
		
		return $return;
	}
	
	public static function distinctions($enabled = TRUE)
	{
		$distinctions = array(
			Model_Job::DISTINCTION_PREMIUM_PLUS => ___('jobs.promotion.premium_plus'),
			Model_Job::DISTINCTION_PREMIUM => ___('jobs.promotion.premium'),
		);
		
		if($enabled)
		{
			$payment_promote = new Payment_Job_Promote;
			$enabled_distinctions = array();
			
			foreach($distinctions as $dist_id => $dist_label)
			{
				$payment_promote->set_distinction($dist_id);
				
				if($payment_promote->is_enabled())
				{
					$enabled_distinctions[$dist_id] = $dist_label;
				}
			}
			
			return $enabled_distinctions;
		}
		else
		{
			return $distinctions;
		}
	}
	
	public static function meta_tags(Model_Job $job)
	{
		$meta = array();
		
		$meta['description'] = array(
			'name' => 'description',
			'content' => Text::limit_chars(strip_tags($job->content), 160, '...', TRUE),
		);
		
		$meta['og:title'] = array(
			'property' => 'og:title',
			'content' => $job->title,
		);
		
		$meta['og:type'] = array(
			'property' => 'og:type',
			'content' => 'object',
		);
		
		$meta['og:url'] = array(
			'property' => 'og:url',
			'content' => self::url($job, 'http'),
		);
		
		return $meta;
	}
	
}
