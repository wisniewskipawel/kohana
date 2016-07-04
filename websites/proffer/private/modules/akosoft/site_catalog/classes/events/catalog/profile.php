<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Catalog_Profile extends Events {
	
	public function on_promotions_box()
	{
		$user = $this->param('user');
		
		return ___('catalog.profile.promotions_box.info', array(':nb' => (int)$user->data->catalog_discount));
	}
	
	public function on_nav()
	{
		switch($this->param('action'))
		{
			case 'closet':
				$current_user = Register::get('current_user');
				
				if($this->param('closet_counter') AND $current_user)
				{
					$title = ___('catalog.profile.closet.tab', array(
						':nb' => Model_Catalog_CompanyToUser::count_by_user($current_user),
					));
				}
				else
				{
					$title = ___('catalog.profile.closet.title');
				}
				
				return HTML::anchor(
					Route::get('site_catalog/profile/closet')->uri(), 
					$title,
					array(
						'class' => ($this->_route_name == 'site_catalog/profile/closet') ? 'active' : NULL,
					)
				);
				
			case 'my':
				$current_user = Register::get('current_user');
		
				$model = new Model_Catalog_Company;
				$model->filter_by_user($current_user);
				$count_companies = $model->count_all();

				$model->filter_by_user($current_user);
				$model->filter_by_active();
				$count_active_companies = $model->count_all();
				
				return View::factory('profile/catalog/nav')
					->set('count_companies', $count_companies)
					->set('count_active_companies', $count_active_companies);
		}
	}
	
}
