<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Frontend_Jobs_Comments extends Controller_Jobs {
	
	public function before()
	{
		parent::before();
		
		if(!Jobs::config('comments.enabled'))
		{
			throw new HTTP_Exception_404;
		}
	}
	
	public function action_add()
	{
		$this->logged_only();
		
		$job = new Model_Job;
		$job->get_by_id($this->request->param('job_id'));
		
		if(!$job->loaded() OR $job->is_archived())
		{
			throw new HTTP_Exception_404;
		}
		
		$parent_comment = $this->request->param('parent_comment_id');
		
		if($parent_comment)
		{
			$model_comment = new Model_Job_Comment;
			$model_comment->find_by_pk($parent_comment);
			
			if(!$model_comment->loaded() OR $job->pk() != $model_comment->job_id)
			{
				throw new HTTP_Exception_404;
			}
			
			$parent_comment = $model_comment;
		}
		
		$form_add_comment = Bform::factory('Frontend_Jobs_Comment_Add');
			
		if($form_add_comment->validate())
		{
			$values = $form_add_comment->get_values();
			$values['user_id'] = $this->_auth->is_logged() ? $this->_current_user->pk() : NULL;

			$comment = new Model_Job_Comment;
			$comment->add_comment($job, $values, $parent_comment);
			
			$job->send_comment_add($comment);

			FlashInfo::add(___('jobs.comments.add.success'));
			$this->redirect(Jobs::uri($job));
		}
		
		$breadcrumbs = $this->_breadcrumb($job);
		$breadcrumbs[$this->template->set_title(___('jobs.comments.add.title'))] = '';

		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('jobs/frontend/comments/add')
			->set('form', $form_add_comment);
	}
	
}
