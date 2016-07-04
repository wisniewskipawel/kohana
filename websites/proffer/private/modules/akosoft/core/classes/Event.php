<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Event {
	
	protected $_params = NULL;
	
	public function __construct()
	{
		
	}
	
	public function params($params)
	{
		$this->_params = $params;
	}
	
	public function param($name)
	{
		return Arr::get($this->_params, $name);
	}
	
}

