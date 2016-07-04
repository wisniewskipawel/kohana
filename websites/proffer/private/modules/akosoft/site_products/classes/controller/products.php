<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Products extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		$this->template->set_title(___('products.title'));
		
		$this->template->rss_links[] = array(
			'title' => ___('products.rss.index.title'),
			'uri' => Route::get('rss')->uri(array('controller' => 'products', 'action' => 'index')),
		);
		
		$this->template->add_meta_property('og:title', Products::config('meta.meta_title'));
		$this->template->add_meta_name('description', Products::config('meta.meta_description'));
		$this->template->add_meta_name('keywords', Products::config('meta.meta_keywords'));
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			Media::css('products.css', 'products/css', array('minify' => TRUE));
			Media::js('products.js', 'products/js', array('minify' => TRUE));
		}
		
		parent::after();
	}
	
}