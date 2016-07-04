<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Products_Sitemap extends Events {
	
	public function on_index()
	{
		$count_products = Model_Product::count_products();
		
		$nb_parts = ceil($count_products / (int)Kohana::$config->load('sitemap.limit_url'));
		$uris = array();
		
		for($i = 0; $i < $nb_parts; $i++)
		{
			$uris[] = array(
				'uri' => Route::get('sitemap/generate')->uri(array(
					'module' => 'site_products',
					'offset' => $i,
				)),
				'lastmod' => Kohana::$config->load('temp.sitemap.lastmod.site_products.'.$i),
			);
		}
		
		return $uris;
	}
	
	public function on_generate()
	{
		$offset = (int)$this->param('offset');
		
		$cache = Cache::instance();
		$response = $cache->get('sitemap.site_products.'.$offset);
		
		if($response === NULL || !Kohana::$config->load('global.sitemap.cache_lifetime'))
		{
			$model_products = new Model_Product;
			$model_products->add_active_conditions();
			
			$limit = Kohana::$config->load('sitemap.limit_url');
			$model_products
				->limit($limit)
				->offset($offset*$limit);
			
			$products = $model_products->find_all();
			
			$sitemap = new Sitemap;

			foreach($products as $product)
			{
				try
				{
					$url = new Sitemap_URL;

					$url->set_loc(products::uri($product, 'http'));
					
					$url->set_last_mod(strtotime($product->product_date_updated ? 
						$product->product_date_updated : $product->annoucement_date_added));
					
					$url->set_change_frequency('daily')
						->set_priority(1);

					$sitemap->add($url);
				}
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, 'sitemap (site_products): :error', array(
						':error' => Kohana_Exception::text($ex),
					));
					
					Kohana_Exception::log($ex, Log::ERROR);
				}
			}
			
			$response = $sitemap->render();
			
			$cache_lifetime = Kohana::$config->load('global.sitemap.cache_lifetime') * Date::DAY;
			$cache->set('sitemap.site_products.'.$offset, $response, $cache_lifetime);
			
			Kohana::$config->load('temp')
				->set('sitemap.lastmod.site_products.'.$offset, time());
		}

		return $response;
	}
	
}