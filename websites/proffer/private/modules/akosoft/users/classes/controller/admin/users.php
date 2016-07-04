<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Users extends Controller_Admin_Main {
	
	public function action_settings_payment()
	{
		$config = Kohana::$config->load('modules');
		$params = $config->as_array();
		
		$form = Bform::factory('Admin_User_Settings_Payment_Register', $params);
		
		if ($form->validate())
		{
			$values = $form->get_values();
			foreach ($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add(___('users.admin.payments.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'admin.settings.payment.title'	=> '/admin/settings/payment',
			'users.admin.payments.title'	=> '/admin/users/settings_payment?type=register'
		));
		
		$this->template->content = View::factory('admin/users/settings_payment')
				->set('form', $form);
	}
	
	public function action_settings() 
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_User_Settings', $config->as_array());
		
		if ($form->validate())
		{
			$values = $form->get_values(FALSE);
			$config->set('bauth', $values['bauth']);
			
			FlashInfo::add(___('users.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'users.title'	=> '/admin/users',
			'settings'		=> '/admin/users/settings'
		));
		
		$this->template->content = View::factory('admin/users/settings')
				->set('form', $form);
	}
	
	public function action_index()
	{
		$filters = array();
		
		$form = Bform::factory('Admin_User_Filters', $filters);

		if ($form->validate())
		{
			$filters = $form->get_values();
		}
		
		$filters['without_groups'] = array('Administrator');

		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'		=> ORM::factory('User')->count_list($filters),
			'view'			=> 'pagination/admin'
		));

		$users = ORM::factory('User')
			->with_statistics()
			->get_list($filters, $pager->offset, $pager->items_per_page);
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'users.title'	=> '/admin/users/index',
		));

		$this->template->content = View::factory('admin/users/index')
				->set('users', $users)
				->set('pager', $pager)
				->set('form', $form);
	}
	
	public function action_add()
	{
		$form = Bform::factory('Admin_User_Add');

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['user_is_paid'] = 1;
			$values['user_status'] = Model_User::STATUS_ACTIVE;
			
			$user = new Model_User;
			$user->add_user($values);
			
			$user->send_new_account_email(Arr::get($values, 'user_pass'));
			
			FlashInfo::add(___('users.admin.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'			=> '/admin',
			'users.title'			=> '/admin/users',
			'users.admin.add.title'	=> '/admin/users/add',
		));

		$this->template->content = View::factory('admin/users/add')
				->set('form', $form);
	}

	public function action_edit()
	{	
		$user = ORM::factory('User')->get_user($this->request->param('id'));

		$form = Bform::factory('Admin_User_Edit', array('user' => $user));

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['clear_groups'] = TRUE;
			
			$user->edit_user($values);
			
			FlashInfo::add(___('users.admin.edit.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'			=> '/admin',
			'users.title'			=> '/admin/users/index',
			'users.admin.edit.title'	=> ''
		));

		$this->template->content = View::factory('admin/users/edit')
				->set('form', $form);
	}

	public function action_delete()
	{
		$user = ORM::factory('User')->find_by_pk($this->request->param('id'));
		
		$user->delete();
		FlashInfo::add(___('users.admin.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_activate()
	{
		$user = ORM::factory('User')->find_by_pk($this->request->param('id'));
		
		if(!$user->loaded())
			throw new HTTP_Exception_404;
		
		$user->edit_user(array(
			'user_status' => Model_User::STATUS_ACTIVE,
		));
		
		FlashInfo::add(___('users.admin.activate.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_promotions()
	{
		$user = ORM::factory('User')
				->find_by_pk($this->request->param('id'));
		
		if(!$user->loaded())
			throw new HTTP_Exception_404;
		
		$form = BForm::factory('Admin_User_Promotions', array('user' => $user));
		
		if($form->validate())
		{
			Events::fire('admin/form/user/promotions', array('form' => $form, 'user' => $user, 'validated' => TRUE));
			
			$user->data->save();
			
			FlashInfo::add('users.admin.promotions.success', 'success');
			$this->redirect('admin/users/send_promotions/'.$user->pk());
		}
		
		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'users.title'				=> '/admin/users/index',
			'users.admin.promotions.title'	=> ''
		));

		$this->template->content = View::factory('admin/users/promotions')
				->set('form', $form);
	}
	
	public function action_send_promotions()
	{
		$user = ORM::factory('User')
				->find_by_pk($this->request->param('id'));
		
		if(!$user->loaded())
			throw new HTTP_Exception_404;
		
		$email = new Model_Email();
		$email->find_by_alias('user_promotions');
		
		if(!$email->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_User_Send_Promotions', array('email' => $email));

		if ($form->validate()) 
		{
			$values = $form->get_values();
			
			$values['message'] = strtr($values['message'], array(
				'%user_name%' => $user->user_name,
				'%company_discount%' => $user->data->catalog_discount,
				'%announcement_points%' => $user->data->announcement_points,
				'%offer_points%' => $user->data->offer_points,
			));
			
			Email::send($user->user_email, $values['subject'], $values['message']);
			
			FlashInfo::add(___('users.admin.send_promotions.success'), 'success');
			$this->redirect('/admin/users/promotions/'.$user->pk());
		}
		
		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'users.title'				=> '/admin/users/index',
			'users.admin.promotions.title'	=> '/admin/users/promotions/'.$user->pk(),
			'users.admin.send_promotions.title'	=> '',
		));

		$this->template->content = View::factory('admin/users/send_promotions')
				->set('form', $form);
	}
	
}
