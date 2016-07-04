<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Profile_Jobs extends Controller_Profile_Main {

	public function action_my()
	{
		$filters = $this->request->query();
		$filters['user_id'] = $this->_current_user;
		$filters['order_by'] = array('id', 'DESC');
		$filters['my'] = TRUE;

		$model = new Model_Job;

		$pager = Pagination::factory(array(
			'items_per_page' => Arr::get($filters, 'on_page', 20),
			'total_items' => $model->apply_filters($filters)->count_all()
		));

		$jobs = $model->get_all($pager->offset, $pager->items_per_page, $filters);

		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('jobs.profile.my.title')) => ''
		));

		$this->template->content = View::factory('jobs/profile/my')
			->set('jobs', $jobs)
			->set('filters_sorters', $filters)
			->set('pager', $pager);
	}

	public function action_delete()
	{
		$job = Model_Job::factory()
			->find_user_job($this->request->param('id'), $this->_current_user);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$job->delete();

		FlashInfo::add(___('jobs.profile.delete.success'), 'success');

		$this->redirect_referrer();
	}

	public function action_statistics()
	{
		$job = Model_Job::factory()
			->find_user_job($this->request->param('id'), $this->_current_user);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$this->template->content = View::factory('jobs/profile/statistics')
			->set('job', $job);

		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			'jobs.profile.my.title' => Route::url('site_jobs/profile/jobs/my'),
			$this->template->set_title(___('jobs.profile.statistics.title')) => ''
		));
	}

	public function action_renew()
	{
		$job = Model_Job::factory()
			->find_user_job($this->request->param('id'), $this->_current_user);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		if(!$job->can_renew())
		{
			$days_left = $job->get_availability_days_left() - 10;
			FlashInfo::add(___('jobs.profile.renew.error_days_left', $days_left, array(
				':days_left' => $days_left,
				)), FlashInfo::ERROR);

			$this->redirect_referrer();
		}

		$form = Bform::factory('Profile_Jobs_Renew');

		if($form->validate())
		{
			$job->renew($form->availability_span->get_value());
			
			FlashInfo::add(___('jobs.profile.renew.success'), 'success');
			$this->redirect(Route::url('site_jobs/profile/jobs/my', array(), 'http'));
		}

		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			'jobs.profile.my.title' => Route::url('site_jobs/profile/jobs/my'),
			$this->template->set_title(___('jobs.profile.renew.title')) => ''
		));

		$this->template->content = View::factory('jobs/profile/renew')
			->set('form', $form);
	}

	public function action_promote()
	{
		$job = Model_Job::factory()
			->find_user_job($this->request->param('id'), $this->_current_user);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		if(!Jobs::distinctions())
		{
			throw new HTTP_Exception_404();
		}
		
		$payment_promote = new Payment_Job_Promote();

		$form = Bform::factory('Profile_Jobs_Promote');

		if($form->validate())
		{
			$values = $form->get_values();
			
			$payment_promote->set_job($job);
			$payment_promote->set_distinction($values['promotion']);
			return $payment_promote->pay();
		}

		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			'jobs.profile.my.title' => Route::url('site_jobs/profile/jobs/my'),
			$this->template->set_title(___('jobs.profile.promote.title')) => ''
		));

		$this->template->content = View::factory('jobs/profile/promote')
			->set('form', $form);
	}

	public function action_edit()
	{
		$job = Model_Job::factory()
			->find_user_job($this->request->param('id'), $this->_current_user);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Profile_Jobs_Edit', array('job' => $job));

		if($form->validate())
		{
			$job->edit_job($form->get_values());
			FlashInfo::add(___('jobs.profile.edit.success'), 'success');
			$this->redirect(Route::url('site_jobs/profile/jobs/my', NULL, 'http'));
		}

		$this->template->content = View::factory('jobs/profile/edit');

		$category = $job->get_last_category();

		if($category AND $category->has_fields())
		{
			$form_attributes = Bform::factory('Profile_Jobs_Attributes', array(
					'job' => $job,
					'category' => $category,
			));

			if($form_attributes->validate())
			{
				$values = $form_attributes->get_values();

				$job->save_attributes(Arr::get($values, 'attributes'));

				FlashInfo::add(___('jobs.profile.edit.attributes.success'), 'success');
				$this->redirect_referrer();
			}

			$this->template->content->set('form_attributes', $form_attributes);
		}

		breadcrumbs::add(array(
			'homepage' => '/',
			'profile' => Route::url('site_profile/frontend/profile/index'),
			'jobs.profile.my.title' => Route::url('site_jobs/profile/jobs/my'),
			$this->template->set_title(___('jobs.profile.edit.title')) => ''
		));

		$this->template->content
			->set('job', $job)
			->set('form', $form);
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
