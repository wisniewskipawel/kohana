<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Print_Catalog extends Controller_Print {
	
	public function action_company()
	{
		$company = Model_Catalog_Company::factory()
			->add_custom_select()
			->only_approved()
			->filter_by_promoted()
			->find_by_pk($this->request->param('id'));
		
		if (!$company->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		$this->template->content = View::factory('print/company')
			->set('company', $company)
			->render();
	}
	
}