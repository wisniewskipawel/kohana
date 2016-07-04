<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Validator_Company_Hours extends Bform_Validator_Base {
	
	public function validate()
	{
		if(empty($this->_value))
		{
			return;
		}
		
		foreach($this->_value as $day => $arr)
		{
			if(
				(!empty($arr['from']) AND !$this->is_valid_time($arr['from'])) 
				OR (!empty($arr['to']) AND !$this->is_valid_time($arr['to']))
			)
			{
				$this->_error =  ___('catalog.forms.validator.company_hours.error');
				$this->exception();
				return;
			}
		}
	}
	
	private function is_valid_time($time)
	{
		return preg_match("/^(2[0-3]|[01]?[0-9])(:[0-5][0-9])?$/", $time);
	}
	
}
