<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Rss_Offers extends Controller_Rss_Main {
	
	public function action_index()
	{
		$offers = ORM::factory('Offer')->get_rss();
		
		$items = array();
		
		foreach($offers as $offer)
		{
			$items[] = array(
				'title' => $offer->offer_title,
				'description' => Text::limit_chars(strip_tags($offer->offer_content), 300),
				'link' => offers::uri($offer),
				'pubDate' => strtotime($offer->offer_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('offers.rss.index.title'),
			'description' => ___('offers.rss.index.description', array(':site_name' => URL::site('/', 'http'))),
			'pubDate' => time(),
			'lastBuildDate' => count($offers) ? strtotime(current($offers->as_array())->offer_date_added) : time(),
		), $items);
	}
	
	
	public function action_category()
	{
		$category = ORM::factory('Offer_Category', $this->request->param('id'));
		
		if ( ! $category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$offers = ORM::factory('Offer')
			->filter_by_category($category)
			->get_rss();
		
		$items = array();
		
		foreach($offers as $offer)
		{
			$items[] = array(
				'title' => $offer->offer_title,
				'description' => Text::limit_chars(strip_tags($offer->offer_content), 300),
				'link' => offers::uri($offer),
				'pubDate' => strtotime($offer->offer_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('offers.rss.category.title', array(':category' => $category->category_name)),
			'description' => ___('offers.rss.category.description', array(
				':category' => $category->category_name,
				':site_name' => URL::site('/', 'http'),
			)),
			'pubDate' => time(),
			'lastBuildDate' => count($offers) ? strtotime(current($offers->as_array())->offer_date_added) : time(),
		), $items);
	}
	
}
