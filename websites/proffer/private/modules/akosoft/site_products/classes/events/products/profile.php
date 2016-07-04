<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Products_Profile extends Events {
	
	public function on_nav()
	{
		switch($this->param('action'))
		{
			case 'closet':
				$current_user = Register::get('current_user');
				
				if($this->param('closet_counter') AND $current_user)
				{
					$title = ___('products.profile.closet.tab', array(
						':nb' => Model_Product_To_User::count_by_user($current_user),
					));
				}
				else
				{
					$title = ___('products.profile.closet.title');
				}
				
				return HTML::anchor(
					Route::get('site_products/profile/closet')->uri(), 
					$title,
					array(
						'class' => ($this->_route_name == 'site_products/profile/closet') ? 'active' : NULL,
					)
				);
				
			case 'my':
				$current_user = Register::get('current_user');
		
				$model = new Model_Product;
				$model->filter_by_user($current_user);
				$count_products = $model->count_all();

				$model->filter_by_user($current_user);
				$model->add_active_conditions();
				$count_active_products = $model->count_all();
				
				return View::factory('profile/products/nav')
					->set('count_products', $count_products)
					->set('count_active_products', $count_active_products);
		}
	}
	
}