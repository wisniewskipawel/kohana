<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Filter_Price extends Bform_Filter_Base {

	public function filter()
	{
		if($this->_value === "")
		{
			return NULL;
		}
		
		return self::parse_price($this->_value);
	}
	
	public static function parse_price($value)
	{
		$value = preg_replace('/[^0-9\.\,]/', '', $value);
						
		if($value)
		{
			return number_format((float)str_replace(',', '.', $value), 2, '.', '');
		}
		
		return '0.00';
	}

}
