<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Admin_Email_BlackList extends Controller_Admin_Main {
	
	public function action_index()
	{
		$emails = new Model_Email_BlackList();
		
		$pagination = Pagination::factory(array(
			'total_items' => $emails->count_all(),
			'items_per_page' => 20,
		));
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			$this->set_title(___('users.admin.blacklist.index.title')) => '/admin/email/blacklist/index',
		));

		$emails->set_pagination($pagination)
			->order_by('id', 'DESC');
		
		$this->template->content = View::factory('admin/email/blacklist/index')
			->set('emails', $emails->find_all())
			->set('pagination', $pagination);
	}
	
	public function action_add()
	{
		$form = Bform::factory('Admin_Email_BlackList_Add');
		
		if($form->validate())
		{
			$email = new Model_Email_BlackList();
			$email->save_email($form->email->get_value());
			
			FlashInfo::add(___('users.admin.blacklist.add.success'));
			$this->redirect('admin/email/blacklist/index');
		}
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.admin.blacklist.index.title' => '/admin/email/blacklist',
			$this->set_title(___('users.admin.blacklist.add.title')) => '/admin/email/blacklist/add',
		));
		
		$this->template->content = View::factory('admin/email/blacklist/add')
			->set('form', $form)
			->render();
	}
	
	public function action_edit()
	{
		$email = new Model_Email_BlackList($this->request->param('id'));
		
		if(!$email->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Email_BlackList_Edit', array('email_blacklist' => $email));
		
		if($form->validate())
		{
			$email->save_email($form->email->get_value());
			
			FlashInfo::add(___('users.admin.blacklist.edit.success'));
			$this->redirect('admin/email/blacklist/index');
		}
		
		breadcrumbs::add(array(
			'homepage' => '/admin',
			'users.admin.blacklist.index.title' => '/admin/email/blacklist/index',
			$this->set_title(___('users.admin.blacklist.edit.title')) => '',
		));
		
		$this->template->content = View::factory('admin/email/blacklist/edit')
			->set('form', $form)
			->render();
	}
	
	public function action_delete()
	{
		$email = new Model_Email_BlackList($this->request->param('id'));
		
		if(!$email->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$email->delete();
		
		FlashInfo::add(___('users.admin.blacklist.delete.success'));
		$this->redirect('admin/email/blacklist/index');
	}
	
}
