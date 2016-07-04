<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Events_Products_Frontend extends Events {
	
	public function on_sidebar_left()
	{
		$name = $this->param('subaction_name');
		
		switch($name)
		{
			case 'categories_list':
				return $this->_categories_list();
				
			case 'tags_cloud':
				return $this->_tags_cloud();
				
			case 'products':
				return $this->_sidebar_products();
		}
	}
	
	protected function _categories_list()
	{
		if(!$this->_is_current_module())
			return FALSE;
		
		$province_id = $this->_request->query('province');
		$city = $this->_request->query('city');
		
		return View::factory('component/products/sidebar_left_categories_list')
			->set('categories', ORM::factory('Product_Category')->get_categories_list(array(
				'province' => $province_id,
				'city' => $city,
			)));
	}
	
	protected function _tags_cloud()
	{
		if(!$this->_is_current_module())
			return FALSE;
		
		$tags = new Model_Product_Tag;
		$tags = $tags->get_tags_cloud(20);
		
		if(count($tags))
		{
			return View::factory('component/products/sidebar_tags_cloud')
				->set('tags', $tags);
		}
	}
	
	protected function _sidebar_products()
	{
		if($this->_route_name != 'site_catalog/home')
			return FALSE;
		
		$product = new Model_Product;
		$product->filter_by_promoted();
		$product->limit(10);
		$product->order_by(DB::expr('RAND()'));
		$products = $product->find_all();
		
		if(count($products))
		{
			return View::factory('component/products/sidebar_products')
				->set('products', $products)
				->render();
		}
	}
	
	public function on_after()
	{
		Media::css('products.global.css', 'products/css', array('minify' => TRUE, 'combine' => TRUE));
	}
	
	public function on_modules_nav()
	{
		return array(
			'url' => Route::get('site_products/home')->uri(),
			'title' => Products::config('header_tab_title'),
			'active' => $this->_is_current_module(),
		);
	}
	
	public function on_modules_box()
	{
		if($this->_is_current_module())
		{
			return NULL;
		}
		
		$products_promoted = ORM::factory('Product')->get_recommended(20);

		if(count($products_promoted))
		{
			return array(
				'name' => 'promoted_products',
				'label' => ___('products.boxes.modules.title'),
				'view' => View::factory('events/products/frontend/modules_box')
					->set('products', $products_promoted)
					->render(),
				'add_btn' => array(
					'url' => Route::url(BAuth::instance()->is_logged() ? 'site_products/frontend/products/add' : 'site_products/frontend/products/pre_add'),
					'title' => ___('products.boxes.modules.add_btn'),
				),
			);
		}
		
		return NULL;
	}
	
}