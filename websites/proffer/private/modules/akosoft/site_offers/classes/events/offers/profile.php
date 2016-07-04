<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Offers_Profile extends Events {
	
	public function on_promotions_box()
	{
		$user = $this->param('user');
		
		return ___('offers.profile.promotions_box.offer_points', array(':nb' => (int)$user->data->offer_points));
	}
	
	public function on_nav()
	{
		switch($this->param('action'))
		{
			case 'closet':
				$current_user = Register::get('current_user');
				
				if($this->param('closet_counter') AND $current_user)
				{
					$title = ___('offers.profile.closet.tab', array(
						':nb' => Model_Offer_To_User::count_by_user($current_user),
					));
				}
				else
				{
					$title = ___('offers.profile.closet.title');
				}
				
				return HTML::anchor(
					Route::get('site_offers/profile/closet')->uri(), 
					$title,
					array(
						'class' => ($this->_route_name == 'site_offers/profile/closet') ? 'active' : NULL,
					)
				);
				
			case 'my':
				$current_user = Register::get('current_user');
		
				$model = new Model_Offer;
				$model->filter_by_user($current_user);
				$count_offers = $model->count_all();

				$model->filter_by_user($current_user);
				$model->add_active_conditions();
				$count_active_offers = $model->count_all();
				
				return View::factory('profile/offers/nav')
					->set('count_offers', $count_offers)
					->set('count_active_offers', $count_active_offers);
		}
	}
	
}
