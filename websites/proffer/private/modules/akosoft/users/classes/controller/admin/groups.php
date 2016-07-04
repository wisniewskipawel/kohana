<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Controller_Admin_Groups extends Controller_Admin_Main {
	
	public function action_index()
	{
		$model = new Model_User_Group;
		$model->filter_no_default_groups();
		$groups = $model->find_all();
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.groups.title' => '/admin/groups/index',
		));
		
		$this->template->content = View::factory('admin/users/groups/index')
			->set('groups', $groups);
	}
	
	public function action_add()
	{
		$form = Bform::factory(new Form_Admin_User_Groups_Add);
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$model = new Model_User_Group;
			$model->add_group($values);
			
			FlashInfo::add(___('users.admin.groups.add.success'));
			$this->redirect('admin/groups/index');
		}
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.groups.title' => '/admin/groups',
			'users.admin.groups.add.title' => '/admin/groups/add',
		));
		
		$this->template->content = View::factory('admin/users/groups/add')
			->set('form', $form);
	}
	
	public function action_edit()
	{
		$group = Model_User_Group::factory()->find_by_pk($this->request->param('id'));
		
		if(!$group->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory(new Form_Admin_User_Groups_Edit, array(
			'group' => $group,
		));
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$group->edit_group($values);
			
			FlashInfo::add(___('users.admin.groups.edit.success'));
			$this->redirect('admin/groups/index');
		}
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.groups.title' => '/admin/groups/index',
			'users.admin.groups.edit.title' => '/admin/groups/edit',
		));
		
		$this->template->content = View::factory('admin/users/groups/edit')
			->set('form', $form);
	}
	
	public function action_delete()
	{
		$group = Model_User_Group::factory()->find_by_pk($this->request->param('id'));
		
		if(!$group->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$group->delete();
		FlashInfo::add(___('users.admin.groups.delete.success'));
		
		$this->redirect('admin/groups/index');
	}
	
	public function action_permissions()
	{
		$group = Model_User_Group::factory()->find_by_pk($this->request->param('id'));
		
		if(!$group->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory(new Form_Admin_User_Groups_Permissions, array(
			'group' => $group,
			'permissions' => Kohana::$config->load('permissions'),
		));
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$model = new Model_User_Group_Permission();
			$model->save_permissions($group, $values);
			
			FlashInfo::add(___('users.admin.groups.permissions.success'));
			$this->redirect('admin/groups/index');
		}
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.title' => '/admin/users',
			'users.admin.groups.title' => '/admin/groups/index',
			'users.admin.groups.permissions.title' => '/admin/groups/permissions',
		));
		
		$this->template->content = View::factory('admin/users/groups/permissions')
			->set('group', $group)
			->set('form', $form);
	}
	
}