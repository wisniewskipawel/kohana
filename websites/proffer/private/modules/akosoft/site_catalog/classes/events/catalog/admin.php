<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Catalog_Admin extends Events {
	
	public function on_users_index()
	{
		if(!BAuth::instance()->permissions('admin/catalog/companies/index'))
			return;
		
		$action = $this->param('action');
		
		if($action == 'statistics')
		{
			return array(
				___('catalog.admin.users.companies_count') => 'catalog_companies_count',
			);
		}
		elseif($action == 'action_links')
		{
			return array(
				'title' => ___('catalog.admin.users.btn'),
				'uri' => 'admin/catalog/companies?user_id='.$this->param('user_id'),
			);
		}
	}
	
	public function on_menu()
	{
		return View::factory('admin/catalog/menu');
	}
	
	public function on_form_user_promotions()
	{
		$form = $this->param('form');
		$user = $this->param('user');
		
		if($this->param('validated'))
		{
			$values = $form->get_values();
			$user->data->catalog_discount = Arr::get($values, 'catalog_discount');
		}
		else
		{
			$form->add_tab('catalog', ___('catalog.title'));
			
			$form->catalog->add_html(FlashInfo::display(___('catalog.admin.users.promotions.no_sms'), FlashInfo::INFO));
			$form->catalog->add_html(___('catalog.admin.users.promotions.info'));
			
			$discounts = array(
				NULL => ___('select.choose'), 
				10 => '10 %',
				20 => '20 %',
				30 => '30 %',
				40 => '40 %',
				50 => '50 %',
				60 => '60 %',
				70 => '70 %',
				80 => '80 %',
				90 => '90 %',
				100 => '100 %',
			);
			
			$form->catalog->add_select('catalog_discount', $discounts, array(
				'label' => 'catalog.admin.users.promotions.catalog_discount', 
				'required' => FALSE,
			));
			
			$form->catalog->add_html(
				___('catalog.admin.users.promotions.user_rabat', array(':nb' => (int)$user->data->catalog_discount))
			);
		}
	}
	
}