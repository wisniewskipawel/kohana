<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Rss_Catalog extends Controller_Rss_Main {
	
	public function action_index()
	{
		$companies = ORM::factory('Catalog_Company')->get_rss();
		
		$items = array();
		
		foreach($companies as $company)
		{
			$items[] = array(
				'title' => $company->company_name,
				'description' => Text::limit_chars(strip_tags($company->company_description), 300),
				'link' => catalog::url($company, 'show'),
				'pubDate' => strtotime($company->company_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('catalog.rss.index.title'),
			'description' => ___('catalog.rss.index.description', array(':site_name' => URL::site('/', 'http'))),
			'pubDate' => time(),
			'lastBuildDate' => count($companies) ? strtotime(current($companies->as_array())->company_date_added) : time(),
		), $items);
	}
	
	public function action_category()
	{
		$category = ORM::factory('Catalog_Category', $this->request->param('id'));
		
		if ( ! $category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$companies = ORM::factory('Catalog_Company')
			->filter_by_category($category)
			->get_rss();
		
		$items = array();
		
		foreach($companies as $company)
		{
			$items[] = array(
				'title' => $company->company_name,
				'description' => Text::limit_chars(strip_tags($company->company_description), 300),
				'link' => catalog::url($company, 'show'),
				'pubDate' => strtotime($company->company_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('catalog.rss.category.title', array(':category' => $category->category_name)),
			'description' => ___('catalog.rss.category.description', array(
				':category' => $category->category_name,
				':site_name' => URL::site('/', 'http'),
			)),
			'pubDate' => time(),
			'lastBuildDate' => count($companies) ? strtotime(current($companies->as_array())->company_date_added) : time(),
		), $items);
	}
	
}
