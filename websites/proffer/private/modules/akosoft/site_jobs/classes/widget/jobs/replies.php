<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Widget_Jobs_Replies extends Widget_Box {
	
	protected $_job = NULL;
	
	public function set_job(Model_Job $job)
	{
		$this->_job = $job;
		return $this;
	}
	
	public function render($view_file = 'jobs/frontend/replies/show')
	{
		$form_add_reply = Bform::factory('Frontend_Jobs_Reply_Add');

		$reply = new Model_Job_Reply();
		$replies = $reply->find_by_job($this->_job);

		$this->set('job', $this->_job)
			->set('form_add_reply', $form_add_reply)
			->set('replies', $replies)
			->set('count_replies', $reply->count_by_job($this->_job));
		
		return parent::render($view_file);
	}
	
}