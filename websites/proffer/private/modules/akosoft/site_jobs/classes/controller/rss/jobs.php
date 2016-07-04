<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Rss_Jobs extends Controller_Rss_Main {
	
	public function action_index()
	{
		$jobs = Model_Job::factory()->get_rss();
		
		$items = array();
		
		foreach($jobs as $job)
		{
			$items[] = array(
				'title' => $job->title,
				'description' => Text::limit_chars(strip_tags($job->content), 300),
				'link' => Jobs::uri($job),
				'pubDate' => strtotime($job->date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('jobs.rss.last.title'),
			'description' => ___('jobs.rss.last.description', array(':site_name' => URL::site('/', 'http'))),
			'pubDate' => time(),
			'lastBuildDate' => count($jobs) ? strtotime(current($jobs->as_array())->date_added) : time(),
		), $items);
	}
	
	
	public function action_category()
	{
		$category = Model_Job_Category::factory()->find_by_pk($this->request->param('id'));
		
		if ( ! $category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$jobs = Model_Job::factory()
			->filter_by_category($category)
			->get_rss();
		
		$items = array();
		
		foreach($jobs as $job)
		{
			$items[] = array(
				'title' => $job->title,
				'description' => Text::limit_chars(strip_tags($job->content), 300),
				'link' => Jobs::uri($job),
				'pubDate' => strtotime($job->date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('jobs.rss.category.title', array(':category' => $category->category_name)),
			'description' => ___('jobs.rss.category.description', array(
				':category' => $category->category_name,
				':site_name' => URL::site('/', 'http'),
			)),
			'pubDate' => time(),
			'lastBuildDate' => count($jobs) ? strtotime(current($jobs->as_array())->date_added) : time(),
		), $items);
	}
	
}
