<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_News extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		$meta_news = Kohana::$config->load('modules.site_news.meta');
		
		$this->template->set_title(___('news.title'));
		
		$this->template->add_meta_property('og:title', Arr::get($meta_news, 'meta_title'));
		$this->template->add_meta_name('description', Arr::get($meta_news, 'meta_description'));
		$this->template->add_meta_name('keywords', Arr::get($meta_news, 'meta_keywords'));
	}
	
	public function action_index() 
	{
		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'	=> ORM::factory('news')
				->where('news_is_published', '=', 1)
				->where('news_visible_from', '<', DB::expr('UNIX_TIMESTAMP(NOW())'))
				->count_all()
		));

		$news = ORM::factory('news')
			->where('news_is_published', '=', 1)
			->where('news_visible_from', '<', DB::expr('UNIX_TIMESTAMP(NOW())'))
			->order_by('news_id', 'DESC')
			->limit($pager->items_per_page)
			->offset($pager->offset)
			->find_all();
		
		$this->template->content = View::factory('frontend/news/index')
				->set('news', $news)
				->set('pager', $pager);
		
		breadcrumbs::add(array(
			'homepage'	=> '/',
			'news.title'	=> '',
		));
	}

	public function action_show() 
	{
		$news = ORM::factory('news')
			->where('news_is_published', '=', 1)
			->where('news_visible_from', '<', DB::expr('UNIX_TIMESTAMP(NOW())'))
			->where('news_id', '=', $this->request->param('id'))
			->find();

		if ( ! $news->news_id) 
		{
			throw new HTTP_Exception_404(404);
		}
		
		if (Modules::enabled('site_comments') AND comments::add_enabled($news))
		{
			$form = Bform::factory('Frontend_Comment_Add');
			
			if ($form->validate())
			{
				$news->add_comment($form->get_values());
				$this->redirect_referrer();
			}
		}

		$this->template->content = View::factory('frontend/news/show')
				->set('news', $news)
				->bind('form', $form);

		$meta_title = $news->news_meta_title;
		if (empty($meta_title)) 
		{
			$meta_title = $news->news_title;
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/',
			'news.title'		=> Route::url('site_news/frontend/news/index', NULL, 'http'),
			$this->template->set_title($meta_title)	=> ''
		));
		
		$this->template->add_meta_property('og:title', $meta_title);

		$meta_keywords = $news->news_meta_keywords;
		if (empty($meta_keywords))
		{
			$meta_keywords = Kohana::$config->load('modules.site_news.meta.keywords');
		}
		$this->template->add_meta_name('keywords', $meta_keywords);

		$meta_description = $news->news_meta_description;
		if (empty($meta_description)) 
		{
			$meta_description = Text::limit_chars(strip_tags($news->news_content), 180);
		}
		$this->template->add_meta_name('description', $meta_description);
		
		$meta_robots = $news->news_meta_robots;
		if (empty($meta_robots))
		{
			$meta_robots = Kohana::$config->load('modules.site_news.meta.robots');
		}
		
		$this->template->add_meta_name('robots', $meta_robots);
	}
	
}
