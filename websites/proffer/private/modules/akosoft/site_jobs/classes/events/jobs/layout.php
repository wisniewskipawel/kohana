<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Jobs_Layout extends Events {
	
	public function on_header_top_counter()
	{
		if(!$this->_is_home())
		{
			return NULL;
		}
		
		$count = Model_Job::count_jobs();
		
		return ___('jobs.header.counter', (int)$count, array(
			':counter' => '<strong>'.$count.'</strong>',
		));
	}
	
	public function on_header_add_button()
	{
		return HTML::anchor(
			Route::get('site_jobs/frontend/jobs/add')->uri(),
			'<span>'.___('jobs.header.add_btn').'</span>',
			array(
				'id' => 'add-job-btn',
				'class' => 'add_btn',
			)
		);
	}
	
	public function on_header_search_box()
	{
		return View::factory('jobs/component/search_box');
	}
	
}