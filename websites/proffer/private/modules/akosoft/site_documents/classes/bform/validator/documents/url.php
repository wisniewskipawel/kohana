<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Documents_Url extends Bform_Validator_Base {

	protected $_error = 'documents.forms.validator.url.error';

	public function validate() 
	{
		if (isset($this->_options['edit']) AND isset($this->_options['document_id'])) 
		{
			$result = ORM::factory('Document')
				->where('document_url', '=', $this->_value)
				->where('document_id', '<>', $this->_options['document_id'])
				->count_all();
		} 
		else 
		{
			$result = ORM::factory('Document')->where('document_url', '=', $this->_value)->count_all();
		}

		if ( (bool) $result)
		{
			$this->exception();
		}
	}
	
}
