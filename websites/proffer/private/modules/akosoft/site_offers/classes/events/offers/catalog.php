<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_Catalog extends Events {
	
	public function on_show_company_pages()
	{
		$company = $this->param('company');

		return array(
			'page' => 'offers',
			'title' => ___('offers.company.title'),
			'module' => 'site_offers',
			'count_entries' => Model_Offer::count_by_company($company),
		);
	}
	
	public function on_show_company_pages_offers()
	{
		$controller = $this->param('controller');
		$company = $this->param('company');
		
		$model_offer = new Model_Offer;
		$model_offer->filter_by_company($company);
		$model_offer->add_active_conditions();
		
		breadcrumbs::add(array(
			$company->company_name => catalog::url($company),
			'offers.company.title' => '',
		));
		
		$controller->template->styles = array('media/offers/css/offers.global.css');
		$controller->template->action_tab = 'offers';
		$controller->template->content = View::factory('company/promotions')
			->set('offers', $model_offer->limit(6)->get_list());
		
		$controller->template->set_title(___('offers.company.title'));
	}
	
	public function on_delete_companies()
	{
		$companies = $this->param('companies');
		
		$model = new Model_Offer;
		$model->where('company_id', 'IN', $companies);
		$offers = $model->find_all();
		
		if(count($offers))
		{
			$model->delete_offers($offers->as_array(NULL, $model->primary_key()));
		}
	}
	
}
