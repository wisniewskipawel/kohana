<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Catalog_Tag extends ORM {

	protected $_table_name = 'catalog_tags';
	protected $_primary_key = 'tag_id';
	protected $_primary_val = 'tag';

	protected $_belongs_to = array(
		'company'		   => array('model' => 'Catalog_Company', 'foreign_key' => 'company_id')
	);
	
	public function save_for_company(Model_Catalog_Company $company, $tags)
	{
		$this->delete_by_company(array($company->pk()));
		
		if(!empty($tags))
		{
			$tags = explode(',', $tags);
			
			$insert_query = DB::insert($this->table_name())
				->columns(array('company_id', 'tag'));
			
			$counter = 0;
			
			foreach ($tags as $tag)
			{
				$tag = UTF8::trim($tag);
				
				if($tag)
				{
					$insert_query->values(array($company->pk(), $tag));
					$counter++;
				}
			}
			
			if($counter > 0)
			{
				$insert_query->execute($this->_db);
			}
		}
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
