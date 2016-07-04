<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Widget_Catalog_Companies_Recommended extends Widget_Box {
	
	public function render($view_file = 'component/catalog/sidebar_left_recommended_companies')
	{
		$companies = new Model_Catalog_Company;

		$companies->filter_by_promotion_type(array(
				Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS,
				Model_Catalog_Company::PROMOTION_TYPE_PREMIUM
			))
			->add_promotion_conditions()
			->add_custom_select()
			->filter_by_active()
			->limit(6)
			->order_by(DB::expr('RAND()'));

		$this->set('companies', $companies->find_all());
		
		return parent::render($view_file);
	}
	
}
