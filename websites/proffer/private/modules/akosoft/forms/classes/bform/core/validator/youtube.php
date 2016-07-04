<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Validator_Youtube extends Bform_Validator_Base {
    
	protected $_error = 'bform.validator.youtube';

	public function validate() 
	{
		if (empty($this->_value))
		{
			return;
		}
		$ytvIDlen = 11; // This is the length of YouTube's video IDs
		// The ID string starts after "v=", which is usually right after
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($this->_value, "?v=");
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
		// bases covered), it will be after an "&":
		if($idStarts === FALSE)
			$idStarts = strpos($this->_value, "&v=");
		// If still FALSE, URL doesn't have a vid ID
		if($idStarts === FALSE) 
		{
			$this->exception();
		}
	}

}
