<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Filter_CleanHTML extends Bform_Filter_Base {

	public function filter() 
	{
		return Security::clean_html_text(
			$this->_value, 
			isset($this->_options['config']) ? $this->_options['config'] : FALSE
		);
	}

}
