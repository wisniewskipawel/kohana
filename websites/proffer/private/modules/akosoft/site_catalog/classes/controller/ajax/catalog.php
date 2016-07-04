<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Ajax_Catalog extends Controller_Ajax_Main {
	
	public function action_get_subcategories_many() 
	{
		$categories = ORM::factory('Catalog_Category')->get_list($this->request->query('category_id'));

		$this->response->body(
			View::factory('ajax/catalog/get_subcategories_many')->set('categories', $categories)->set('nb_select', $this->request->param('nb_select'))
		);
	}
	
	public function action_curtain()
	{
		$model = new Model_Catalog_Company();
		$model->filter_by_active()
			->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		switch($this->request->query('show'))
		{
			case 'email':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body(HTML::mailto($model->company_email, URL::idna_decode($model->company_email)));
				break;
			
			case 'telephone':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body($model->company_telephone);
				break;
			
			default:
				throw new HTTP_Exception_400;
		}
	}
	
}
