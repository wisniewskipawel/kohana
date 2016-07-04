<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
abstract class Controller_Jobs extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		$this->template->set_title(___('jobs.module.name'));
		
		$this->template->rss_links[] = array(
			'title' => ___('jobs.rss.last.title'),
			'uri' => Route::get('rss')->uri(array('controller' => 'jobs', 'action' => 'index')),
		);
		
		$this->template->add_meta_property('og:title', Jobs::config('meta.meta_title'));
		$this->template->add_meta_name('description', Jobs::config('meta.meta_description'));
		$this->template->add_meta_name('keywords', Jobs::config('meta.meta_keywords'));
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			Media::css('jobs.css', 'jobs/css', array('minify' => TRUE));
		}
		
		parent::after();
	}
	
	public function _breadcrumb($model = NULL)
	{
		$breadcrumbs = array(
			'jobs.module.name' => Route::url('site_jobs/frontend/jobs/index'),
		);

		if($model instanceof Model_Job)
		{
			if(in_array(Route::name($this->request->route()), array(
					'site_jobs/frontend/jobs/search',
					'site_jobs/frontend/jobs/advanced_search',
				)))
			{
				$breadcrumbs['jobs.search.results'] = $this->request->referrer();
			}
			else
			{
				if($model->has_category())
				{
					$breadcrumbs = Arr::merge($breadcrumbs, $this->_breadcrumb_categories($model->get_last_category()));
				}
			}

			$breadcrumbs[$model->title] = URL::site(Jobs::uri($model));
		}
		elseif($model instanceof Model_Job_Category)
		{
			$breadcrumbs = Arr::merge($breadcrumbs, $this->_breadcrumb_categories($model));
		}

		return $breadcrumbs;
	}
	
	protected function _breadcrumb_categories(Model_Job_Category $category)
	{
		$breadcrumbs = array(); 
		
		$categories = Model_Job_Category::factory()->get_path($category);
			
		foreach($categories as $parent_category)
		{
			if(!$parent_category->is_root())
			{
				$breadcrumbs[$parent_category->category_name] = Route::url('site_jobs/frontend/jobs/category', array(
					'category_id' => $parent_category->pk(),
					'title' => URL::title($parent_category->category_name),
				));
			}
		}
		
		return $breadcrumbs;
	}
	
}