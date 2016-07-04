<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_News_Frontend extends Events {
	
	public function on_main_bottom()
	{
		if(Modules::enabled('site_posts') AND Kohana::$config->load('modules.site_posts.settings.main_popular_enabled'))
		{
			return;
		}
		
		 $news = ORM::factory('news')
				->where('news_is_published', '=', 1)
				->where('news_visible_from', '<', DB::expr('UNIX_TIMESTAMP(NOW())'))
				->order_by('news_date_added', 'DESC')
				->limit(10)
				->find_all();

		return View::factory('component/news/main_bottom')
				->set('news', $news);
	}
	
	public function on_after()
	{
		Media::css('news.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
	}
	
}
