<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Event_Module extends Event {
	
	protected $_module = NULL;
	protected $_current_module = NULL;
	protected $_request = NULL;
	protected $_route_name = NULL;
	
	public function __construct(Module $module)
	{
		$this->_module = $module;
		
		$this->_current_module = Modules::instance()->current_module();
		
		$this->_request = Request::initial();
		
		$this->_route_name = ($this->_request AND $this->_request->route()) ? 
			Route::name($this->_request->route()) : NULL;
	}
	
	protected function _is_current_module()
	{
		if(!$this->_current_module)
			return FALSE;
		
		return $this->_current_module->get_name()  == $this->_module->get_name();
	}
	
	protected function _is_home()
	{
		return $this->_route_name == $this->_module->get_name().'/home';
	}
	
	protected function _is_homepage()
	{
		return $this->_current_module AND $this->_route_name == $this->_current_module->get_name().'/home';
	}
	
}
