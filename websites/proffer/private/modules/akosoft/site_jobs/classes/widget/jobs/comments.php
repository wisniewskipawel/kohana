<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Widget_Jobs_Comments extends Widget_Box {
	
	protected $_job = NULL;
	
	public function set_job(Model_Job $job)
	{
		$this->_job = $job;
		return $this;
	}
	
	public function render($view_file = 'jobs/frontend/comments/show')
	{
		if(Jobs::config('comments.enabled'))
		{
			$form_add_comment = Bform::factory('Frontend_Jobs_Comment_Add');

			$comment = new Model_Job_Comment;
			$comments = $comment->find_by_job($this->_job);

			$this->set('job', $this->_job)
				->set('form_add_comment', $form_add_comment)
				->set('comments', $comments)
				->set('count_comments', $comment->count_by_job($this->_job));
		
			return parent::render($view_file);
		}
	}
	
}