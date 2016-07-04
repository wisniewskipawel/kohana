<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Filter_Url extends Bform_Filter_Base {

	public function filter()
	{
		return URL::title($this->_value);
	}

}
