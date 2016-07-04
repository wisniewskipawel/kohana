<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Events_Jobs_Frontend extends Events {
	
	public function on_sidebar_left()
	{
		if(!$this->_is_current_module())
			return FALSE;
		
		$name = $this->param('subaction_name');
		
		if ($name == 'categories_list')
		{
			return $this->_categories_list();
		}
	}
	
	protected function _categories_list()
	{
		if (!$this->_is_current_module())
		{
			return;
		}
		
		return Widget_Box::factory('Jobs_Categories')->render();
	}
	
	public function on_modules_nav()
	{
		return array(
			'url' => Route::get('site_jobs/home')->uri(),
			'title' => Jobs::config('header_tab_title'),
			'active' => $this->_is_current_module(),
		);
	}
	
}