<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Offers extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		$this->template->set_title(___('offers.title'));
		
		$this->template->rss_links[] = array(
			'title' => ___('offers.rss.index.title'),
			'uri' => Route::get('rss')->uri(array('controller' => 'offers', 'action' => 'index')),
		);
		
		$this->template->add_meta_property('og:title', offers::config('meta.meta_title'));
		$this->template->add_meta_name('description', offers::config('meta.meta_description'));
		$this->template->add_meta_name('keywords', offers::config('meta.meta_keywords'));
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			Media::css('offers.css', 'offers/css', array('minify' => TRUE));
			Media::js('offers.js', 'offers/js', array('minify' => TRUE));
		}
		
		parent::after();
	}
	
	protected function _breadcrumb($model = NULL)
	{
		$breadcrumbs['offers.title'] = Route::url('site_offers/frontend/offers/index');

		if($model instanceof Model_Offer)
		{
			$category = $model->get_last_category();

			if($category && $category->loaded())
			{
				$parents = $category->get_parents(FALSE, TRUE);

				foreach ($parents as $c)
				{
					$breadcrumbs[$c->category_name] = Route::url('site_offers/frontend/offers/category', array(
						'category_id' => $c->category_id,
						'title' => URL::title($c->category_name)
					), 'http');
				}
			}

			$breadcrumbs[Text::limit_chars($model->offer_title, 40, '...', TRUE)] = Route::url('site_offers/frontend/offers/show', array(
				'offer_id' => $model->pk(),
				'title' => URL::title($model->offer_title)
			), 'http');
		}
		
		if($model instanceof Model_Offer_Category)
		{
			$parents = $model->get_parents(FALSE, TRUE);

			foreach ($parents as $c)
			{
				$breadcrumbs[$c->category_name] = Route::url('site_offers/frontend/offers/category', array(
					'category_id' => $c->category_id,
					'title' => URL::title($c->category_name)
				), 'http');
			}
		}
		
		return $breadcrumbs;
	}
	
}