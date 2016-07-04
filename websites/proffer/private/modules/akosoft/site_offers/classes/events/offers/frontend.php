<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_Frontend extends Events {
	
	public function on_sidebar_left()
	{
		$name = $this->param('subaction_name');
		
		if ($name == 'categories_list')
		{
			return $this->_categories_list();
		}
	}

	protected function _categories_list()
	{
		if (!$this->_is_current_module())
		{
			return;
		}
		
		$province_id = $this->_request->query('province');
		$city = $this->_request->query('city');
		
		return View::factory('component/offers/sidebar_left_categories_list')
			->set('categories', ORM::factory('Offer_Category')->get_categories_list(array(
				'province' => $province_id,
				'city' => $city,
			)));
	}
	
	public function on_modules_nav()
	{
		return array(
			'url' => Route::get('site_offers/home')->uri(),
			'title' => offers::config('header_tab_title'),
			'active' => $this->_is_current_module(),
		);
	}
	
	public function on_main_index_top()
	{
		if(!$this->_is_home()) 
		{
			return;
		}
		
		return View::factory('component/offers/frontend_main_index_top');
	}
	
	public function on_after()
	{
		Media::css('offers.global.css', 'offers/css', array('minify' => TRUE, 'combine' => TRUE));
	}
	
	public function on_modules_box()
	{
		if($this->_is_current_module())
		{
			return NULL;
		}
		
		$offers_promoted = ORM::factory('Offer')->get_recommended(20);

		if(count($offers_promoted))
		{
			return array(
				'name' => 'promoted_offers',
				'label' => ___('offers.boxes.modules.title'),
				'view' => View::factory('events/offers/frontend/modules_box')
					->set('offers', $offers_promoted)
					->render(),
				'add_btn' => array(
					'url' => Route::url(BAuth::instance()->is_logged() ? 'site_offers/frontend/offers/add' : 'site_offers/frontend/offers/pre_add'),
					'title' => ___('offers.boxes.modules.add_btn'),
				),
			);
		}
		
		return NULL;
	}
	
}

