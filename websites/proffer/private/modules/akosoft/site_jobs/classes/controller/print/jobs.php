<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Print_Jobs extends Controller_Print {
	
	public function action_index()
	{
		$job = Model_Job::factory()
			->with_count_replies()
			->get_by_id($this->request->param('id'));
		
		if(!$job->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$this->template->content = View::factory('jobs/print')
			->set('job', $job)
			->render();
	}
	
}