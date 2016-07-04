<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Validator_Company_Slug extends Bform_Validator_Base {
	
	public function validate()
	{
		if(empty($this->_value))
		{
			return;
		}
		
		if(!preg_match( '/^[a-z0-9_]++$/iD', $this->_value))
		{
			$this->_error =  'catalog.forms.validator.company_slug.invalid_chars';
			$this->exception();
			return;
		}
		
		$company = new Model_Catalog_Company();
		$company->find_by_slug($this->_value);
		
		if($company->loaded())
		{
			if(!isset($this->_options['edit_company']) OR (isset($this->_options['edit_company']) AND $company->pk() != $this->_options['edit_company']->pk()))
			{
				$this->_error =  'catalog.forms.validator.company_slug.duplicate';
				$this->exception();
				return;
			}
		}
	}
	
}
