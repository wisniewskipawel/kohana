<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Admins extends Controller_Admin_Main {

	public function action_index()
	{
		$model = new Model_User;

		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $model->count_admins(),
			'view' => 'pagination/admin'
		));

		$admins = $model->set_pagination($pager)->find_admins();

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			$this->template->set_title(___('users.admin.admins.title')) => '/admin/admins/index',
		));

		$this->template->content = View::factory('admin/users/admins/index')
			->set('admins', $admins)
			->set('pager', $pager);
	}

	public function action_add()
	{
		$form = Bform::factory(new Form_Admin_Admins_Add);

		if($form->validate())
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
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.admins.title' => '/admin/admins',
			$this->template->set_title(___('users.admin.admins.add.title')) => '/admin/admins/add',
		));

		$this->template->content = View::factory('admin/users/admins/add')
			->set('form', $form);
	}

	public function action_edit()
	{
		$user = Model_User::factory()->get_user($this->request->param('id'));

		$form = Bform::factory(new Form_Admin_Admins_Edit, array('user' => $user));

		if($form->validate())
		{
			$values = $form->get_values();
			$values['clear_groups'] = TRUE;

			$user->edit_user($values);

			FlashInfo::add(___('users.admin.edit.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.admins.title' => '/admin/admins/index',
			$this->template->set_title(___('users.admin.admins.edit.title')) => '/admin/admins/edit',
		));

		$this->template->content = View::factory('admin/users/admins/edit')
			->set('form', $form);
	}

	public function action_delete()
	{
		$user = Model_User::factory()->find_by_pk($this->request->param('id'));

		$user->delete();
		
		FlashInfo::add(___('users.admin.delete.success'), 'success');
		$this->redirect_referrer();
	}

}
