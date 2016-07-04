<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Filter_Clean extends Bform_Driver_Base {
    
	public function filter()
	{
		return Security::clean_text($this->_value);
	}
    
}
