<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Rss_Products extends Controller_Rss_Main {
	
	public function action_index()
	{
		$products = ORM::factory('Product')->get_rss();
		
		$items = array();
		
		foreach($products as $product)
		{
			$items[] = array(
				'title' => $product->product_title,
				'description' => Text::limit_chars(strip_tags($product->product_content), 300),
				'link' => products::uri($product),
				'pubDate' => strtotime($product->product_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('products.rss.index.title'),
			'description' => ___('products.rss.index.description', array(':site_name' => URL::site('/', 'http'))),
			'pubDate' => time(),
			'lastBuildDate' => count($products) ? strtotime(current($products->as_array())->product_date_added) : time(),
		), $items);
	}
	
	
	public function action_category()
	{
		$category = ORM::factory('Product_Category', $this->request->param('id'));
		
		if ( ! $category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$products = ORM::factory('Product')
			->filter_by_category($category)
			->get_rss();
		
		$items = array();
		
		foreach($products as $product)
		{
			$items[] = array(
				'title' => $product->product_title,
				'description' => Text::limit_chars(strip_tags($product->product_content), 300),
				'link' => products::uri($product),
				'pubDate' => strtotime($product->product_date_added)
			);
		}
		
		$this->render_rss(array(
			'title' => ___('products.rss.category.title', array(':category' => $category->category_name)),
			'description' => ___('products.rss.category.description', array(
				':category' => $category->category_name,
				':site_name' => URL::site('/', 'http'),
			)),
			'pubDate' => time(),
			'lastBuildDate' => count($products) ? strtotime(current($products->as_array())->product_date_added) : time(),
		), $items);
	}
	
}
