<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Catalog_Layout extends Events {
	
	public function on_header_top_counter()
	{
		if(!$this->_is_home())
		{
			return NULL;
		}
		
		$count = (int)Model_Catalog_Company::count_companies();
		
		return ___('catalog.header.counter', $count, array(
			':counter' => '<strong>'.$count.'</strong>',
		));
	}
	
	public function on_header_add_button()
	{
		return HTML::anchor(
			Route::get('site_catalog/frontend/catalog/pre_add')->uri(),
			'<span>'.___('catalog.header.add_btn').'</span>',
			array(
				'id' => 'add-company',
				'class' => 'add_btn',
			)
		); 
	}
	
	public function on_header_search_box()
	{
		return View::factory('component/catalog/search_box');
	}
	
}