<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Catalog_CompanyToUser extends ORM {

	protected $_table_name = 'catalog_companies_to_users';
	protected $_primary_key = 'company_to_user_id';

	protected $_belongs_to = array(
		'company'	  => array('model' => 'Catalog_Company', 'foreign_key' => 'company_id'),
	);
	
	public function delete_by_user(Model_User $user, Model_Catalog_Company $company)
	{
		$this->where('user_id', '=', (int)$user->pk())
			->where('company_id', '=', (int)$company->pk())
			->find();
		
		if($this->loaded())
		{
			$this->delete();
			return TRUE;
		}
		
		return FALSE;
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
	
	public static function count_by_user(Model_User $user)
	{
		$self = new self();
		$self->with('company');
		
		$model = new Model_Catalog_Company;
		
		$self->where('company.'.$model->primary_key(), 'IS NOT', NULL);
		
		return $self->where($self->object_name().'.user_id', '=', (int)$user->pk())
				->count_all();
	}
	
}
