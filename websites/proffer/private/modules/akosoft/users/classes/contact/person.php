<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Contact_Person extends Contact {
	
	public $first_name;
	
	public $last_name;
	
	public function display_name()
	{
		if($this->first_name AND $this->last_name)
		{
			return $this->first_name.' '.$this->last_name;
		}
		else
		{
			return parent::display_name();
		}
	}
	
}