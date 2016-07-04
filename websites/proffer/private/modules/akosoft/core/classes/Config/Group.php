<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2012, AkoSoft
*/
class Config_Group extends Kohana_Config_Group {
	
	public function delete_group($group_name)
	{
		if(method_exists($this->_parent_instance, 'delete_group'))
		{
			$this->_parent_instance->delete_group($this->_group_name.'.'.$group_name);
		}
		
		return $this;
	}
	
}