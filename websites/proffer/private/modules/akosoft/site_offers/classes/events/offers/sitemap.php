<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_Sitemap extends Events {
	
	public function on_index()
	{
		$count_offers = Model_Offer::count_offers();
		
		$nb_parts = ceil($count_offers / (int)Kohana::$config->load('sitemap.limit_url'));
		$uris = array();
		
		for($i = 0; $i < $nb_parts; $i++)
		{
			$uris[] = array(
				'uri' => Route::get('sitemap/generate')->uri(array(
					'module' => 'site_offers',
					'offset' => $i,
				)),
				'lastmod' => Kohana::$config->load('temp.sitemap.lastmod.site_offers.'.$i),
			);
		}
		
		return $uris;
	}
	
	public function on_generate()
	{
		$offset = (int)$this->param('offset');
		
		$cache = Cache::instance();
		$response = $cache->get('sitemap.site_offers.'.$offset);
		
		if($response === NULL || !Kohana::$config->load('global.sitemap.cache_lifetime'))
		{
			$model = new Model_Offer;
			$model->add_active_conditions();
			
			$limit = Kohana::$config->load('sitemap.limit_url');
			$model->limit($limit)
				->offset($offset*$limit);
			
			$offers = $model->find_all();
			
			$sitemap = new Sitemap;

			foreach($offers as $offer)
			{
				try
				{
					$url = new Sitemap_URL;

					$url->set_loc(Route::url('site_offers/frontend/offers/show', array(
							'offer_id' => $offer->pk(),
							'title' => URL::title($offer->offer_title),
						), 'http'));
					
					$url->set_last_mod(strtotime($offer->offer_date_updated ?
						$offer->offer_date_updated : $offer->offer_date_added));
					
					$url->set_change_frequency('daily')
						->set_priority(1);

					$sitemap->add($url);
				}
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, 'sitemap (site_offers): :error', array(
						':error' => Kohana_Exception::text($ex),
					));
					
					Kohana_Exception::log($ex, Log::ERROR);
				}
			}
			
			$response = $sitemap->render();

			$cache_lifetime = Kohana::$config->load('global.sitemap.cache_lifetime') * Date::DAY;
			$cache->set('sitemap.site_offers.'.$offset, $response, $cache_lifetime);
			
			Kohana::$config->load('temp')
				->set('sitemap.lastmod.site_offers.'.$offset, time());
		}

		return $response;
	}
	
}