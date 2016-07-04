<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Products_Admin extends Events {
	
	public function on_users_index()
	{
		if(!BAuth::instance()->permissions('admin/products/index'))
			return;
		
		$action = $this->param('action');
		
		if($action == 'statistics')
		{
			return array(
				___('products.admin.users.products_normal_count') => 'products_normal_count',
				___('products.admin.users.products_promoted_count') => 'products_promoted_count',
			);
		}
		elseif($action == 'action_links')
		{
			return array(
				'title' => ___('products.admin.users.action_links.title'),
				'uri' => 'admin/products/index?user_id='.$this->param('user_id'),
			);
		}
	}
	
	public function on_menu()
	{
		return View::factory('admin/products/menu');
	}
	
	public function on_index()
	{
		$main_categories_count = ORM::factory('Product_Category')->where('category_level', '=', 2)->count_all();
		$sub_categories_count = ORM::factory('Product_Category')->where('category_level', '>', 2)->count_all();
		$active_products_count = ORM::factory('Product')
			->where('product_availability', '>', DB::expr('NOW()'))
			->where('product_is_approved', '=', 1)
			->count_all();
		$not_active_products_count = ORM::factory('Product')
			->where('product_availability', '<', DB::expr('NOW()'))
			->or_where('product_is_approved', '=', 0)
			->count_all();
		$to_approve_products_count = ORM::factory('Product')
			->where('product_is_approved', '=', 0)
			->count_all();
		
		return View::factory('component/products/admin/index')
				->bind('main_categories_count', $main_categories_count)
				->bind('sub_categories_count', $sub_categories_count)
				->bind('active_products_count', $active_products_count)
				->bind('not_active_products_count', $not_active_products_count)
				->bind('to_approve_products_count', $to_approve_products_count);
	}
	
}
