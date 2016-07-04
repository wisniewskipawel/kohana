<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Ads extends Controller_Admin_Main {
	
	public function action_settings_payment()
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_Ad_Settings_Payment', array('values' => $config->as_array()));
		
		if ($form->validate())
		{
			$values = $form->get_values();
			foreach ($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add(___('ads.admin.payment.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'admin.settings.payment.title'	=> '/admin/settings/payment',
			$this->set_title(___('ads.admin.payment.title')) => '/admin/ads/settings_payment',
		));
		
		$this->template->content = View::factory('admin/ads/settings_payment')
				->set('form', $form);
	}
	
	public function action_send_promotions()
	{
		$user = new Model_User((int)$this->request->param('id'));
		
		if(!$user->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Ad_SendPromotions');
		
		if ($form->validate())
		{
			Email::send($user->user_email, $form->subject->get_value(), $form->message->get_value());
			FlashInfo::add(___('ads.admin.send_promotions.success'), 'success');
			$this->redirect('/admin/ads/users');
		}
		
		breadcrumbs::add(array(
			'homepage'		 => '/admin',
			'ads.admin.index.title' => '/admin/ads/index',
			'ads.admin.users.title' => '/admin/ads/users',
			$this->set_title(___('ads.admin.send_promotions.title'))	   => ''
		));
		
		$this->template->content = View::factory('admin/ads/send_promotions')
				->set('form', $form);
	}
	
	public function action_index()
	{
		$filters['which'] = $this->request->param('id');
		$filters['user_id'] = $this->request->query('user_id');
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'	   => ORM::factory('Ad')->count_admin($filters),
			'view'			  => 'pagination/admin'
		));
		
		$ads = ORM::factory('Ad')->get_admin($pager->offset, $pager->items_per_page, $filters);
		
		$breadcrumbs = array(
			'homepage'		=> '/admin',
			'ads.admin.index.title'	=> '/admin/ads',
		);
		$breadcrumbs = Arr::merge($breadcrumbs, ads::admin_list_link($this->request->param('id'), ( ! empty($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : '')));
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('admin/ads/index')
				->set('ads', $ads)
				->set('pager', $pager);
	}
	
	public function action_delete()
	{
		$ad = ORM::factory('Ad', $this->request->param('id'));
		$ad->delete();
		
		FlashInfo::add(___('ads.admin.delete.success', 'one'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_add()
	{
		$form = Bform::factory('Admin_Ad_Add');
		
		if ($form->validate())
		{
			ORM::factory('Ad')->add_ad($form->get_values());
			FlashInfo::add(___('ads.admin.add.success'), 'success');
			$this->redirect('/admin/ads/index/active');
		}
		
		breadcrumbs::add(array(
			'homepage'			=> '/admin',
			'ads.admin.index.title'	=> '/admin/ads',
			$this->set_title(___('ads.admin.add.title'))	=> '/admin/ads/add',
		));
		
		$this->template->content = View::factory('admin/ads/add')
				->set('form', $form);
	}
	
	public function action_renew()
	{
		$ad = ORM::factory('Ad', $this->request->param('id'));
		
		$form = Bform::factory('Admin_Ad_Renew', $ad->as_array());
		
		if ($form->validate()) 
		{
			$ad->edit_ad($form->get_values());
			FlashInfo::add(___('ads.admin.renew.success'), 'success');
			$this->redirect('/admin/ads/index/active');
		}
		
		breadcrumbs::add(array(
			'homepage'			=> '/admin',
			'ads.admin.index.title'	=> '/admin/ads',
			$this->set_title(___('ads.admin.renew.title'))	=> '',
		));
		
		$this->template->content = View::factory('admin/ads/renew')
				->set('form', $form);
	}
	
	public function action_edit() 
	{
		$ad = ORM::factory('Ad', $this->request->param('id'));
		
		$form = Bform::factory('Admin_Ad_Edit', $ad->as_array());
		
		if ($form->validate()) 
		{
			$ad->edit_ad($form->get_values());
			FlashInfo::add(___('ads.admin.edit.success'), 'success');
			$this->redirect('/admin/ads/index/active');
		}
		
		breadcrumbs::add(array(
			'homepage'			=> '/admin',
			'ads.admin.index.title'	=> '/admin/ads',
			$this->set_title(___('ads.admin.edit.title'))	=> '',
		));
		
		$this->template->content = View::factory('admin/ads/edit')
				->set('form', $form);
	}
	
	public function action_users() 
	{
		$users_to_count = ORM::factory('User')
				->with_groups(array('Adsystem'))
				->find_all();
		
		$count = count($users_to_count);
		
		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $count
		));
		
		$users = ORM::factory('User')
				->select(array(DB::expr('
					(
						SELECT
							COUNT(*)
						FROM
							ads AS ad
						WHERE
							ad.user_id = user.user_id
					)
				'), 'ads_count'))
				->with_groups(array('Adsystem'))
				->without_groups(array('Administrator'))
				->limit($pager->items_per_page)
				->offset($pager->offset)
				->find_all();
		
		breadcrumbs::add(array(
			'homepage'		 => '/admin',
			'ads.admin.index.title' => '/admin/ads',
			'ads.admin.users.title' => '/admin/ads/users',
		));
		
		$this->template->content = View::factory('admin/ads/users')
				->set('users', $users)
				->set('pager', $pager);
	}
	
	public function action_many() 
	{
		$ads = array();
		
		if (isset($_POST['ads'])) 
		{	
			foreach ($_POST['ads'] as $id)
			{
				$ads[] = ORM::factory('Ad', $id);
			}
		}
		foreach ($ads as $a)
		{
			if ($_POST['action'] == 'delete')
			{
				$a->delete();
			}
		}
		if ($_POST['action'] == 'delete') 
		{
			FlashInfo::add(___('ads.admin.delete.success', 'many'), 'success');
		}
		
		$this->redirect_referrer();
	}
	
	public function action_settings()
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_Ad_Settings', $config->as_array());
		
		if ($form->validate())
		{
			$values = $form->get_values();
			$config->set('site_ads', $values['site_ads']);
			
			FlashInfo::add(___('ads.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'ads.admin.index.title' => '/admin/ads/index',
			$this->set_title(___('ads.admin.settings.title'))	=> '/admin/ads/settings',
		));
		
		$this->template->content = View::factory('admin/ads/settings')
				->set('form', $form);
	}
	
}
