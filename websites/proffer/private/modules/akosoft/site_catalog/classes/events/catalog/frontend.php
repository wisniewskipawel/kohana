<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Catalog_Frontend extends Events {

	public function on_main_index_top()
	{
		if(!Request::$initial->route())
			return;

		if(!$this->_is_home())
		{
			return;
		}

		return View::factory('component/catalog/frontend_main_index_top');
	}

	public function on_sidebar_left()
	{
		$name = $this->param('subaction_name');

		if ($name == 'promoted_box')
		{
			return $this->_promoted_box();
		}
		elseif($name == 'categories')
		{
			 return $this->_categories();
		}
		elseif($name == 'recommended_companies')
		{
			return $this->_recommended_companies();
		}
	}

	protected function _recommended_companies()
	{
		if (View_Template::instance('frontend')->config('site_catalog.widgets.recommended.enabled') AND $this->_is_current_module())
		{
			return Widget_Box::factory('catalog/companies/recommended');
		}
	}

	protected function _promoted_box()
	{
		if (Request::$initial->controller() != 'catalog')
		{
			return;
		}

		 $companies_promoted = ORM::factory('Catalog_Company')
			->with_image(TRUE)
			->limit(3)
			->filter_by_promotion_type(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS)
			->filter_by_promoted()
			->filter_by_active()
			->order_by(DB::expr('RAND()'))
			->find_all();

		return View::factory('component/catalog/frontend_sidebar_left_promoted_box')
				 ->set('companies', $companies_promoted);
	}

	protected function _categories()
	{
		if($this->_is_home() OR !$this->_is_current_module())
			return;

		$filters = array();

		if(in_array($this->_route_name, array(
			'site_catalog/frontend/catalog/show_category',
		)))
		{
			$query = $this->_request->query();

			$filters['province'] = Arr::get($query, 'province', NULL);
			$filters['city'] = Arr::get($query, 'city');
		}

		$categories = new Model_Catalog_Category;

		return View::factory('component/catalog/sidebar_left_categories_list')
			->set('categories', $categories->get_categories_list($filters));
	}
	
	public function on_after()
	{
		Media::css('catalog.global.css', 'catalog/css', array('minify' => TRUE, 'combine' => TRUE));
	}
	
	public function on_modules_nav()
	{
		return array(
			'url' => Route::get('site_catalog/home')->uri(),
			'title' => catalog::config('header_tab_title'),
			'active' => $this->_is_current_module(),
		);
	}
	
	public function on_modules_box()
	{
		if($this->_is_current_module())
		{
			return NULL;
		}
		
		$companies_promoted = ORM::factory('Catalog_Company')->get_recommended(20);

		if(count($companies_promoted))
		{
			return array(
				'module' => 'site_catalog',
				'name' => 'promoted_companies',
				'label' => ___('catalog.boxes.modules.title'),
				'view' => View::factory('events/catalog/frontend/modules_box')
					->set('companies', $companies_promoted)
					->render(),
				'add_btn' => array(
					'url' => Route::url('site_catalog/frontend/catalog/pre_add'),
					'title' => ___('catalog.boxes.modules.add_btn'),
				),
			);
		}
		
	}

}
