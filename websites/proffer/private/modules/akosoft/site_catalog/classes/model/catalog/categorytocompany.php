<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Catalog_CategoryToCompany extends ORM {

	protected $_table_name = 'catalog_categories_to_companies';
	protected $_primary_key = 'category_to_company_id';
	protected $_primary_val = 'company_id';
	
	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->execute($this->_db);
	}
	
	public function delete_by_company($company)
	{
		if(empty($company))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('company_id', is_array($company) ? 'IN' : '=', $company)
			->execute($this->_db);
	}

}
