<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_Admin extends Events {
	
	public function on_users_index()
	{
		if(!BAuth::instance()->permissions('admin/offers/index'))
			return;
		
		$action = $this->param('action');
		
		if($action == 'statistics')
		{
			return array(
				___('offers.admin.users.offers_count') => 'offers_count',
			);
		}
		elseif($action == 'action_links')
		{
			return array(
				'title' => ___('offers.admin.users.action_links.title'),
				'uri' => 'admin/offers/index?user_id='.$this->param('user_id'),
			);
		}
	}
	
	public function on_menu()
	{
		return View::factory('admin/offers/menu');
	}
	
	public function on_form_user_promotions()
	{
		$form = $this->param('form');
		$user = $this->param('user');
		
		if($this->param('validated'))
		{
			$values = $form->get_values();
			$user->data->offer_points = Arr::get($values, 'offer_points');
		}
		else
		{
			$form->add_tab('offers', ___('offers.title'));

			$form->offers->add_input_text('offer_points', array(
				'label' => 'offers.admin.users.promotions.offer_points', 
				'required' => FALSE,
			));
			
			$form->offers->add_html(
				___('offers.admin.users.promotions.info', array(':nb' => (int)$user->data->offer_points))
			);
		}
	}
	
}