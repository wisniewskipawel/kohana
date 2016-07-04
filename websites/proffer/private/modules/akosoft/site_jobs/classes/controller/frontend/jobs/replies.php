<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Frontend_Jobs_Replies extends Controller_Jobs {
	
	public function action_add()
	{
		$this->logged_only();
		
		$job = new Model_Job;
		$job->get_by_id($this->request->param('job_id'));
		
		if(!$job->loaded() OR $job->is_archived())
		{
			throw new HTTP_Exception_404;
		}
		
		$form_add_reply = Bform::factory('Frontend_Jobs_Reply_Add');
			
		if($form_add_reply->validate())
		{
			$values = $form_add_reply->get_values();
			$values['user_id'] = $this->_auth->is_logged() ? $this->_current_user->pk() : NULL;

			$reply = new Model_Job_Reply();
			$reply->add_reply($job, $values);
			
			$job->send_reply_add($reply);

			FlashInfo::add(___('jobs.replies.add.success'));
			$this->redirect(Jobs::uri($job));
		}
		
		$breadcrumbs = $this->_breadcrumb($job);
		$breadcrumbs[$this->template->set_title(___('jobs.replies.add.title'))] = '';

		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('jobs/frontend/replies/add')
			->set('form', $form_add_reply);
	}
	
}
