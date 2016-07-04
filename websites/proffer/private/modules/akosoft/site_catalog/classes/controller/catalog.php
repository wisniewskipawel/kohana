<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Catalog extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		$this->template->set_title(___('catalog.title'));
		
		$this->template->rss_links[] = array(
			'title' => ___('catalog.rss.index.title'),
			'uri' => Route::get('rss')->uri(array('controller' => 'catalog', 'action' => 'index')),
		);
		
		$this->template->add_meta_property('og:title', catalog::config('meta.meta_title'));
		$this->template->add_meta_name('description', catalog::config('meta.meta_description'));
		$this->template->add_meta_name('keywords', catalog::config('meta.meta_keywords'));
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			Media::css('catalog.css', 'catalog/css', array('minify' => TRUE));
			Media::js('catalog.js', 'catalog/js', array('minify' => TRUE));
			
			if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled'))
			{
				Media::css('rateit.css', 'js/libs/rateit/');
				Media::js('jquery.rateit.min.js', 'js/libs/rateit/');
			}
			
		}
		
		parent::after();
	}
	
	public function _breadcrumb($model = NULL)
	{
		$breadcrumbs = array(
			'catalog.title'	=> Route::url('site_catalog/home', NULL, 'http'),
		);
		
		if($model instanceof Model_Catalog_Company)
		{
			if($model->has_main_category())
			{
				$breadcrumbs_cats = catalog::breadcrumbs($model->get_main_category());
				$breadcrumbs = Arr::merge($breadcrumbs, $breadcrumbs_cats);
			}
			
			$breadcrumbs[$model->company_name] = catalog::url($model);
		}
		elseif($model instanceof Model_Catalog_Category)
		{
			$breadcrumbs_cats = catalog::breadcrumbs($model);
			$breadcrumbs = Arr::merge($breadcrumbs, $breadcrumbs_cats);
		}
		
		return $breadcrumbs;
	}
	
}
