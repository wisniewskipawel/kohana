<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */
class Events_Jobs_Sitemap extends Events {

	public function on_index()
	{
		$count_jobs = Model_Job::count_jobs();

		$nb_parts = ceil($count_jobs / (int)Kohana::$config->load('sitemap.limit_url'));
		$uris = array();

		for($i = 0; $i < $nb_parts; $i++)
		{
			$uris[] = array(
				'uri' => Route::get('sitemap/generate')->uri(array(
					'module' => 'site_jobs',
					'offset' => $i,
				)),
				'lastmod' => Kohana::$config->load('temp.sitemap.lastmod.site_jobs.' . $i),
			);
		}

		return $uris;
	}

	public function on_generate()
	{
		$offset = (int)$this->param('offset');

		$cache = Cache::instance();
		$response = $cache->get('sitemap.site_jobs.' . $offset);

		if($response === NULL || !Kohana::$config->load('global.sitemap.cache_lifetime'))
		{
			$model_jobs = new Model_Job;
			$model_jobs->filter_by_active();

			$limit = Kohana::$config->load('sitemap.limit_url');
			$model_jobs
				->limit($limit)
				->offset($offset * $limit);

			$jobs = $model_jobs->find_all();

			$sitemap = new Sitemap;

			foreach($jobs as $job)
			{
				try
				{
					$url = new Sitemap_URL;

					$url->set_loc(Jobs::url($job, 'http'));

					$url->set_last_mod(strtotime($job->date_updated ?
								$job->date_updated : $job->date_added));

					$url->set_change_frequency('daily')
						->set_priority(1);

					$sitemap->add($url);
				}
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, 'sitemap (site_jobs): :error', array(
						':error' => Kohana_Exception::text($ex),
					));

					Kohana_Exception::log($ex, Log::ERROR);
				}
			}

			$response = $sitemap->render();

			$cache_lifetime = Kohana::$config->load('global.sitemap.cache_lifetime') * Date::DAY;
			$cache->set('sitemap.site_jobs.' . $offset, $response, $cache_lifetime);

			Kohana::$config->load('temp')
				->set('sitemap.lastmod.site_jobs.' . $offset, time());
		}

		return $response;
	}

}
