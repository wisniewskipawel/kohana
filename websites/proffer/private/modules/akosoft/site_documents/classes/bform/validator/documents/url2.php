<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Documents_Url2 extends Bform_Validator_Dependency {

	public function validate() 
	{
		$values = $this->get_dependencies_values_from_drivers();

		if ($this->_value == 'auto') 
		{
			$result = ORM::factory('Document')->where('document_url', '=', URL::title($values['document_title']))->count_all();

			if ($result) 
			{
				$this->_error = 'documents.forms.validator.url2.error';
				$this->exception();
			}
		}
	}
}
