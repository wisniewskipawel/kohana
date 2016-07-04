<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Events_Products_Catalog extends Events {
	
	public function on_show_company_pages()
	{
		$company = $this->param('company');

		return array(
			'page' => 'products',
			'title' => ___('products.title'),
			'module' => 'site_products',
			'count_entries' => Model_Product::count_by_company($company),
		);
	}
	
	public function on_show_company_pages_products()
	{
		$controller = $this->param('controller');
		$company = $this->param('company');
		
		$model = new Model_product;
		$model->filter_by_company($company);
		$model->add_active_conditions();
		
		breadcrumbs::add(array(
			$company->company_name => catalog::url($company),
			$controller->template->set_title(___('products.title')) => '',
		));
		
		$controller->template->styles = array('media/products/css/products.global.css');
		$controller->template->action_tab = 'products';
		$controller->template->content = View::factory('company/products')
			->set('products', $model->limit(6)->get_list());
	}
	
	public function on_delete_companies()
	{
		$companies = $this->param('companies');
		
		$model = new Model_Product;
		$model->where('company_id', 'IN', $companies);
		$products = $model->find_all();
		
		if(count($products))
		{
			$model->delete_products($products->as_array(NULL, $model->primary_key()));
		}
	}
	
}
