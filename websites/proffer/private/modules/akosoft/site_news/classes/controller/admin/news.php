<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_News extends Controller_Admin_Main {

	public function action_settings() 
	{
		$config = Kohana::$config->load('modules');
		
		$form = Bform::factory(new Form_Admin_News_Settings, (array)$config->get('site_news'));
		
		if ($form->validate()) 
		{
			$values = $form->get_values();
			$config->set('site_news', $values);
			
			FlashInfo::add(___('news.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'news.title'	=> '/admin/news',
			$this->set_title(___('news.admin.settings.title'))	=> '/admin/news/settings'
		));
		
		$this->template->content = View::factory('admin/news/settings')
				->set('form', $form);
	}
	
	public function action_index() 
	{
		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items'	=> ORM::factory('news')->count_all()
		));
		$news = ORM::factory('news')->get_all_admin($pager->offset, $pager->items_per_page);

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			$this->set_title(___('news.title'))	=> '/admin/news/index',
		));

		$this->template->content = View::factory('admin/news/index')
				->set('news', $news)
				->set('pager', $pager);
	}

	public function action_add() 
	{
		$form = Bform::factory('Admin_News_Add');

		if ($form->validate()) {
			ORM::factory('news')->add_news($form->get_values());
			
			FlashInfo::add(___('news.admin.add.success'), 'success');
			$this->redirect('/admin/news');
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'news.title'	=> '/admin/news',
			$this->set_title(___('news.admin.add.title')) => '/admin/news/add',
		));

		$this->template->content = View::factory('admin/news/add')
				->set('form', $form);
	}

	public function action_delete() 
	{
		$news = ORM::factory('news')->where('news_id', '=', $this->request->param('id'))->find();
		$news->delete();
		
		FlashInfo::add(___('news.admin.delete.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_edit() 
	{
		$news = ORM::factory('News')->where('news_id', '=', $this->request->param('id'))->find();
		$images = $news->images->where('object_type', '=', 'news')->order_by('image_id', 'DESC')->find_all();

		$form = Bform::factory('Admin_News_Edit', $news->as_array());

		if ($form->validate()) 
		{
			$news->edit_news($form->get_values());
			
			FlashInfo::add(___('news.admin.edit.success'), 'success');
			$this->redirect('/admin/news');
		}

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'news.title'	=> '/admin/news/index',
			$this->set_title(___('news.admin.edit.title')) => '',
		));

		$this->template->content = View::factory('admin/news/edit')
				->set('form', $form)
				->set('images', $images)
				->set('news', $news);
	}

	public function action_many() 
	{
		$post = $this->request->post();
		
		if (isset($post['news']) && isset($post['action'])) 
		{
			$news = ORM::factory('news')->where('news_id', 'IN', $post['news'])->find_all();

			if ($post['action'] == 'delete') 
			{
				foreach ($news as $n) 
				{
					$n->delete();
				}
				
				FlashInfo::add(___('news.admin.delete.success', 'many'), 'success');
			}
		}
		$this->redirect_referrer();
	}
	
}
