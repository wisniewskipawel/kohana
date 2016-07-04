<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Notifier extends Controller_Admin_Main {
	
	public function action_index()
	{
		$notifier = new Model_Notifier();
		
		$pagination = Pagination::factory(array(
			'items_pre_page'	=> 20,
			'total_items'		=> $notifier->reset(FALSE)->count_all(),
		));
		
		$notifier->set_pagination($pagination);
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('notifiers.title'))	=> '/admin/notifier/index',
		));

		$this->template->content = View::factory('admin/notifier/index')
				->set('subscribers', $notifier->find_subscribers())
				->set('pagination', $pagination);
	}
	
	public function action_edit()
	{
		$notifier = new Model_Notifier((int)$this->request->param('id'));
		
		if(!$notifier->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Notifier_Edit', array('notifier' => $notifier));
		
		if ($form->validate()) 
		{
			$values = $form->get_values();
			$notifier->edit_notifier($values);
			
			FlashInfo::add(___('notifiers.admin.edit.success'), 'success');
			$this->redirect('admin/notifier');
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'notifiers.title'		=> '/admin/notifier/index',
			$this->set_title(___('notifiers.admin.edit.title')) => '',
		));
		
		$this->template->content = View::factory('admin/notifier/edit')
				->set('form', $form);
	}
	
	public function action_delete()
	{
		$notifier = new Model_Notifier((int)$this->request->param('id'));
		
		if(!$notifier->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$notifier->delete();
		
		$this->redirect_referrer();
	}
	
	public function action_settings()
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_Notifier_Settings', Notifier::config());
		
		if ($form->validate()) 
		{
			$values = $form->get_values();
			$config->set('site_notifier.settings', $values);
			
			FlashInfo::add(___('notifiers.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'notifiers.title'		=> '/admin/notifier',
			$this->set_title(___('notifiers.admin.settings.title')) => '/admin/notifier/settings',
		));
		
		$this->template->content = View::factory('admin/notifier/settings')
				->set('form', $form);
	}
	
}
