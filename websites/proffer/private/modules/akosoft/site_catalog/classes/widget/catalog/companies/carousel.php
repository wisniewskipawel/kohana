<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Widget_Catalog_Companies_Carousel extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$companies_last = ORM::factory('Catalog_Company')
			->add_promotion_conditions()
			->add_custom_select()
			->filter_by_active()
			->limit(6)
			->order_by('company_date_added', 'DESC')
			->find_all();
		
		$companies_promoted = ORM::factory('Catalog_Company')
			->filter_by_promotion_type(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS)
			->add_promotion_conditions()
			->add_custom_select()
			->filter_by_active()
			->limit(6)
			->order_by(DB::expr('RAND()'))
			->find_all();
		
		$companies_popular = ORM::factory('Catalog_Company')
			->add_promotion_conditions()
			->add_custom_select()
			->filter_by_active()
			->limit(6)
			->order_by('company_visits', 'DESC')
			->find_all();
		
		return View::factory('widget/catalog/companies/carousel')
			->set('companies_last', $companies_last)
			->set('companies_popular', $companies_popular)
			->set('companies_promoted', $companies_promoted);
	}
	
}