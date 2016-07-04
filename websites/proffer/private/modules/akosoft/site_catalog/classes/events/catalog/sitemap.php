<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Catalog_Sitemap extends Events {
	
	public function on_index()
	{
		$count_companies = Model_Catalog_Company::count_companies();
		
		$nb_parts = ceil($count_companies / (int)Kohana::$config->load('sitemap.limit_url'));
		$uris = array();
		
		for($i = 0; $i < $nb_parts; $i++)
		{
			$uris[] = array(
				'uri' => Route::get('sitemap/generate')->uri(array(
					'module' => 'site_catalog',
					'offset' => $i,
				)),
				'lastmod' => Kohana::$config->load('temp.sitemap.lastmod.site_catalog.'.$i),
			);
		}
		
		return $uris;
	}
	
	public function on_generate()
	{
		$offset = (int)$this->param('offset');
		
		$cache = Cache::instance();
		$response = $cache->get('sitemap.site_catalog.'.$offset);
		
		if($response === NULL || !Kohana::$config->load('global.sitemap.cache_lifetime'))
		{
			$model = new Model_Catalog_Company();
			$model->add_promotion_conditions();
			
			$limit = Kohana::$config->load('sitemap.limit_url');
			$model
				->limit($limit)
				->offset($offset*$limit);
			
			$companies = $model->find_all();
			
			$sitemap = new Sitemap;

			foreach($companies as $company)
			{
				try
				{
					$url = new Sitemap_URL;

					$url->set_loc(catalog::url($company));
					
					$url->set_last_mod(strtotime($company->company_date_updated ? 
						$company->company_date_updated : $company->company_date_added));
					
					$url->set_change_frequency('daily')
						->set_priority(1);

					$sitemap->add($url);
				}
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, 'sitemap (site_catalog): :error', array(
						':error' => Kohana_Exception::text($ex),
					));
					
					Kohana_Exception::log($ex, Log::ERROR);
				}
			}
			
			$response = $sitemap->render();

			$cache_lifetime = Kohana::$config->load('global.sitemap.cache_lifetime') * Date::DAY;
			$cache->set('sitemap.site_catalog.'.$offset, $response, $cache_lifetime);
			
			Kohana::$config->load('temp')
				->set('sitemap.lastmod.site_catalog.'.$offset, time());
		}

		return $response;
	}
	
}