<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Ads_Frontend extends Events {
	
	public function on_main_index_top()
	{
		if ($this->_is_homepage())
		{
			return View::factory('component/ads/frontend_main_index_top');
		}
	}

	public function on_sidebar_left()
	{
		if(View_Template::instance('frontend')->config('site_ads.index_box_enabled'))
		{
			return Widget_Box::factory('Ads_Text');
		}
	}
	
	public function on_footer()
	{
		$ads = ORM::factory('Ad')->get_by_type_many(Model_Ad::TEXT_C1, 7);

		return View::factory('component/ads/footer')
				->set('ads', $ads);
	}

	public function on_main_bottom()
	{
		return View::factory('component/ads/main_bottom');
	}
	
	public function on_after()
	{
		Media::css('ads.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
	}
	
}