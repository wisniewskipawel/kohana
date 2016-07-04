<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Controller_Profile_Jobs_Closet extends Controller_Profile_Main {
	
	public function action_index()
	{
		$filters = $this->request->query();
		$filters['closet_user'] = $this->_current_user;
		
		$model = new Model_Job;
		
		$count_jobs = $model->apply_filters($filters)->count_all();
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $count_jobs,
		));
		
		$jobs = $model->get_all($pager->offset, $pager->items_per_page, $filters);
		
		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('jobs.profile.closet.title')) => ''
		));

		$this->template->content = View::factory('jobs/profile/closet')
			->set('jobs', $jobs)
			->set('filters_sorters', $filters)
			->set('pager', $pager);
	}
	
	public function action_add() 
	{
		$job = Model_Job::factory()->get_by_id($this->request->param('id'));

		if ( ! $job->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		Model_Job_Closet::factory()->add_to_closet($job, $this->_current_user);

		FlashInfo::add(___('jobs.profile.closet.add.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete() 
	{
		$model = Model_Job_Closet::factory()
			->find_closet_job($this->request->param('id'), $this->_current_user);

		if (!$model->loaded()) 
		{
			throw new HTTP_Exception_404();
		}
	
		$model->delete();

		FlashInfo::add(___('jobs.profile.closet.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function after()
	{
		if($this->auto_render)
		{
			Media::css('jobs.css', 'jobs/css', array('minify' => TRUE));
		}

		parent::after();
	}
	
}
