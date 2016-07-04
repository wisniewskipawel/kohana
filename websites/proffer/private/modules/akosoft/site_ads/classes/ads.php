<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class ads {
	
	const PLACE_A = 1;
	const PLACE_AB = 2;
	const PLACE_AC = 3;
	const PLACE_B = 5;
	const PLACE_C = 6;
	const PLACE_D = 7;
	const PLACE_E = 8;
	const PLACE_F = 9;
	const PLACE_BB = 10;
	const PLACE_G = 11;
	//const PLACE_H = 12;
	//const PLACE_I = 13;
	const PLACE_J = 14;
	const PLACE_GALLERIES_A = 20;
	const PLACE_GALLERIES_B = 21;
	const PLACE_D2 = 22;
	const PLACE_POSTS_A = 23;

	public static function get($place, $force_limit = NULL, $random = TRUE)
	{
		$types = self::place_types($place);
		
		if(empty($types))
		{
			return NULL;
		}
		
		$ad = new Model_Ad();
		return $ad->find_by_types($types, array(
			'limit' => $force_limit,
		));
	}
	
	public static function count($place)
	{
		$types = self::place_types($place);
		
		if(empty($types))
		{
			return NULL;
		}
		
		$ad = new Model_Ad();
		return $ad->count_by_types($types);
	}
	
	public static function show($place, $force_limit = 1, $view = 'frontend/ads/show')
	{
		$ads = self::get($place, $force_limit, TRUE);
		
		if(count($ads))
		{
			return View::factory($view)
				->set('place', $place)
				->set('ad', $ads)
				->set('options', array(
					'limit' => $force_limit,
				));
		}
		
		return NULL;
	}
	
	public static function place_types($place)
	{
		return Kohana::$config->load('ads.places.'.$place.'.types');
	}
	
	public static function place_name($place)
	{
		$place_name = Kohana::$config->load('ads.places.'.$place.'.name');
		
		return $place_name ? $place_name : 'banner_place_'.$place;
	}
	
	public static function availabilities($ad_type)
	{
		$availabilities = array(
			Model_Ad::TEXT_C => array(
				14  => ___('date.days_nb', 14, array(':nb' => 14)),
				30  => ___('date.days_nb', 30, array(':nb' => 30)),
			)
		);
		
		$result = Arr::get($availabilities, $ad_type, NULL);
		if ($result === NULL)
		{
			throw new Exception('Check API!');
		}
		return $result;
	}
	
	public static function types()
	{
		$ads = array(
			Model_Ad::BANNER_A => ___('ads.types.'.Model_Ad::BANNER_A),
			Model_Ad::BANNER_AB => ___('ads.types.'.Model_Ad::BANNER_AB),
			Model_Ad::BANNER_AC => ___('ads.types.'.Model_Ad::BANNER_AC),
			Model_Ad::BANNER_F => ___('ads.types.'.Model_Ad::BANNER_F),
			Model_Ad::BANNER_B => ___('ads.types.'.Model_Ad::BANNER_B),
			Model_Ad::TEXT_C => ___('ads.types.'.Model_Ad::TEXT_C),
			Model_Ad::TEXT_C1 => ___('ads.types.'.Model_Ad::TEXT_C1),
			Model_Ad::SKYCRAPER_D => ___('ads.types.'.Model_Ad::SKYCRAPER_D),
			Model_Ad::SKYCRAPER_D2 => ___('ads.types.'.Model_Ad::SKYCRAPER_D2),
			Model_Ad::BANNER_E => ___('ads.types.'.Model_Ad::BANNER_E),
			Model_Ad::BANNER_G => ___('ads.types.'.Model_Ad::BANNER_G),
		);
		
		if(Modules::enabled('site_posts'))
		{
			if(Kohana::$config->load('modules.site_posts.settings.ad_H_enabled'))
			{
			}
			
			$ads[Model_Ad::BANNER_J] = ___('ads.types.'.Model_Ad::BANNER_J);
			$ads[Model_Ad::BANNER_POSTS_A] = ___('ads.types.'.Model_Ad::BANNER_POSTS_A);
		}
		
		if(Modules::enabled('site_galleries'))
		{
			$ads[Model_Ad::BANNER_GALLERIES_A] = ___('ads.types.'.Model_Ad::BANNER_GALLERIES_A);
			$ads[Model_Ad::BANNER_GALLERIES_B] = ___('ads.types.'.Model_Ad::BANNER_GALLERIES_B);
		}
		
		return $ads;
	}
	
	public static function type($type)
	{
		return Arr::get(self::types(), $type);
	}
	
	public static function admin_list_link($type = NULL, $query_string = NULL)
	{
		$session = Session::instance();
		
		if (empty($type) AND empty($query_string))
		{
			$type = $session->get('admin/ads/list/type', '');
			$query_string = $session->get('admin/ads/list/query_string', '');
		}
		else
		{
			$session->set('admin/ads/list/type', $type);
			$session->set('admin/ads/list/query_string', $query_string);
		}
		
		switch ($type)
		{
			case 'active':
				return array(___('ads.admin.index.active') => '/admin/ads/index/active' . $query_string);
				break;
			
			case 'not_active':
				return array(___('ads.admin.index.not_active') => '/admin/ads/index/not_active' . $query_string);
				break;
			
			case '';
				return array(___('ads.admin.index.all') => '/admin/ads/index' . $query_string);
				break;
		}
	}
	
}
