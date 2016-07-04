<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Newsletter_Subscribers extends Controller_Admin_Main {

	public function action_index()
	{
		$filters = $this->_session->get('admin_newsletter_subscribers_filters', array());
		$form = Bform::factory('Admin_Newsletter_Filter_Subscriber', $filters);

		if ($form->validate()) 
		{
			$this->_session->set('admin_newsletter_subscribers_filters', $form->get_values(TRUE));
			$this->redirect_referrer();
		}

		$pager = Pagination::factory(array(
			'view'			=> 'pagination/admin',
			'items_per_page'	=> 20,
			'total_items'		=> ORM::factory('newsletter_subscriber')->count_all_admin($filters)
		));

		$subscribers = ORM::factory('newsletter_subscriber')->get_list_admin($filters, $pager->items_per_page, $pager->offset);

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'newsletter.title'	=> '/admin/newsletter',
			$this->set_title(___('newsletter.admin.subscribers.title'))	=> '/admin/newsletter/subscribers'
		));

		$this->template->content = View::factory('admin/newsletter/subscribers/index')
				->set('subscribers', $subscribers)
				->set('pager', $pager)
				->set('form', $form);
	}

	public function action_delete()
	{
		$subscriber = ORM::factory('newsletter_subscriber', $this->request->param('id'));
		$subscriber->delete();

		FlashInfo::add(___('newsletter.admin.subscribers.delete.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_many()
	{
		$post = $this->request->post();
		
		if (isset($post['subscribers']))
		{
			foreach ($post['subscribers'] as $id)
			{
				$s = ORM::factory('Newsletter_Subscriber', $id);
				if ($post['action'] == 'delete')
				{
					$s->delete();
				}
			}
			
			if ($post['action'] == 'delete')
			{
				FlashInfo::add(___('newsletter.admin.subscribers.delete.success', 'many'), 'success');
			}
		}
		$this->redirect_referrer();
	}
	
}
