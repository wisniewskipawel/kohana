<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Products_Layout extends Events {
	
	public function on_header_top_counter()
	{
		if(!$this->_is_home())
		{
			return NULL;
		}
		
		$counter = Model_Product::count_products();
		
		return ___('products.layout.counter', $counter, array(
			':counter' => '<strong>'.$counter.'</strong>',
		));
	}
	
	public function on_header_add_button()
	{
		return HTML::anchor(
			Route::get(BAuth::instance()->is_logged() ? 'site_products/frontend/products/add' : 'site_products/frontend/products/pre_add')->uri(),
			'<span>'.___('products.layout.add_btn').'</span>',
			array(
				'id' => 'add-products',
				'class' => 'add_btn',
			)
		);
	}
	
	public function on_header_search_box()
	{
		return View::factory('component/products/search_box');
	}
	
}