<?php
if(Modules::enabled('site_ads') AND $template->config('site_ads.index_box_enabled'))
{
	$ads = ORM::factory('Ad')->get_by_type_many(Model_Ad::TEXT_C, 3);
	echo View::factory('component/ads/sidebar_left')->set('ads', $ads);
}

if ($template->config('site_catalog.widgets.recommended.enabled'))
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

	echo View::factory('component/catalog/sidebar_left_recommended_companies')
			 ->set('companies', $companies->find_all());
}
