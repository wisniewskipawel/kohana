<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Newsletter extends Controller_Admin_Main {
	
	public function action_send()
	{
		$form = Bform::factory('Admin_Newsletter_Send');
		
		if ($form->validate()) 
		{
			ORM::factory('Newsletter_Letter')->add_letter($form->get_values());
			
			FlashInfo::add(___('newsletter.admin.send.success'), 'success');
			$this->redirect('/admin/newsletter/queue');
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'newsletter.title'	=> '/admin/newsletter',
			$this->set_title(___('newsletter.admin.send.title'))	=> '/admin/newsletter/send'
		));
		
		$this->template->content = View::factory('admin/newsletter/send')
				->set('form', $form);
	}
	
	public function action_queue()
	{
		$queue = ORM::factory('Newsletter_Queue')->get_list();
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'newsletter.title'	=> '/admin/newsletter',
			$this->set_title(___('newsletter.admin.queue.title'))	=> '/admin/newsletter/queue',
		));
		
		$this->template->content = View::factory('admin/newsletter/queue')
				->set('queue', $queue);
	}
	
	public function action_clear_filters()
	{
		$this->_session->delete('admin_newsletter_subscribers_filters');
		$this->redirect_referrer();
	}
	
	public function action_show()
	{
		$letter = ORM::factory('Newsletter_Letter', $this->request->param('id'));
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'newsletter.title'	=> '/admin/newsletter',
			'newsletter.admin.queue.title'	=> '/admin/newsletter/queue',
			$this->set_title(___('newsletter.admin.show.title'))	=> ''
		));
		
		$this->template->content = View::factory('admin/newsletter/show')
				->set('letter', $letter);
	}
	
	public function action_cancel()
	{
		$queue = ORM::factory('Newsletter_Queue')
				->where('letter_id', '=', $this->request->param('id'))
				->find_all();
		
		foreach ($queue as $q)
		{
			$q->delete();
		}
		
		FlashInfo::add(___('newsletter.admin.cancel.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_index()
	{
		$queue_count = ORM::factory('Newsletter_Queue')->count_all();
		$subscribers_count = ORM::factory('Newsletter_Subscriber')->count_all();
		
		$this->template->content = View::factory('admin/newsletter/index')
				->set('queue_count', $queue_count)
				->set('subscribers_count', $subscribers_count);
	}
	
	public function action_settings()
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory('Admin_Newsletter_Settings', $config->as_array());
		
		if ($form->validate())
		{
			$values = $form->get_values(FALSE, TRUE);
			$config->set('site_newsletter', $values['site_newsletter']);
			
			FlashInfo::add(___('newsletter.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'newsletter.title'	=> '/admin/newsletter',
			$this->set_title(___('newsletter.admin.settings.title'))	=> '/admin/newsletter/settings',
		));
		
		$this->template->content = View::factory('admin/newsletter/settings')
				->set('form', $form);
	}
	
}
