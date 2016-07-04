<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Filter_IDNA extends Bform_Filter_Base {

	public function filter()
	{
		return URL::idna_encode($this->_value);
	}

}
