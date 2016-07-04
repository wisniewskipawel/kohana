<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Jobs extends Controller_Admin_Main {

	public function action_index()
	{
		$params = $this->request->query();

		$filters = array();
		if(!empty($params['user_id']))
		{
			$filters['user_id'] = $params['user_id'];
		}
		$filters['which'] = $this->request->query('which');

		if(!empty($params['search_pk']))
		{
			$filters['primary_key'] = $params['search_pk'];
		}

		$model = Model_Job::factory();

		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $model->count_admin($filters),
			'view' => 'pagination/admin'
		));

		$jobs = $model->get_admin($filters, $pager->offset, $pager->items_per_page);

		breadcrumbs::add(array(
			'homepage' => '/admin',
			$this->template->set_title(___('jobs.module.name')) => '/admin/jobs/index',
		));

		$this->template->content = View::factory('jobs/admin/index')
			->set('pager', $pager)
			->set('jobs', $jobs)
			->set('filters', $filters)
			->set('which', $this->_get_which());
	}

	public function action_add()
	{
		$form = Bform::factory('Admin_Jobs_Add');

		if($form->validate())
		{
			$values = $form->get_values();
			
			Model_Job::factory()->add_admin_job($values);
			
			FlashInfo::add('jobs.admin.add.success', 'success');
			$this->redirect('admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			$this->template->set_title(___('jobs.admin.add.title')) => '/admin/jobs/add'
		));

		$this->template->content = View::factory('jobs/admin/add')
			->set('form', $form);
	}

	public function action_edit()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Jobs_Edit', array('job' => $job));

		if($form->validate())
		{
			$values = $form->get_values();
			
			$job->edit_admin_job($values);
			
			FlashInfo::add('jobs.admin.edit.success', 'success');
			$this->redirect('/admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs/index',
			$this->template->set_title(___('jobs.admin.edit.title')) => '',
		));

		$this->template->content = View::factory('jobs/admin/edit')
			->set('form', $form);
	}

	public function action_edit_attributes()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Jobs_Attributes', array('job' => $job));

		if($form->validate())
		{
			$values = $form->get_values();

			$job->save_attributes(Arr::get($values, 'attributes'));

			FlashInfo::add('jobs.admin.edit_attributes.success', 'success');
			$this->redirect('/admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs/index',
			$this->template->set_title(___('jobs.admin.edit_attributes.title')) => '',
		));

		$this->template->content = View::factory('jobs/admin/edit_attributes')
			->set('form', $form);
	}

	public function action_delete()
	{
		$model = new Model_Job;
		$model->find_by_pk($this->request->param('id'));

		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_Delete', array(
			'email' => $model->get_email_address(),
			'delete_text' => $model->title,
		));

		if($form->validate())
		{
			$form->send_message();

			$model->delete();

			FlashInfo::add(___('jobs.admin.delete.success', 'one'), 'success');
			$this->redirect('admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs/index',
			$this->template->set_title(___('jobs.admin.delete.title')) => '',
		));

		$this->template->content = View::factory('jobs/admin/delete')
			->set('job', $model)
			->set('form', $form);
	}

	public function action_many()
	{
		if(isset($_POST['jobs']) AND isset($_POST['action']))
		{
			foreach($_POST['jobs'] as $id)
			{
				$job = Model_Job::factory()->find_by_pk($id);

				if($_POST['action'] == 'delete')
				{
					$job->delete();
				}
				elseif($_POST['action'] == 'approve')
				{
					$job->approve();
				}
			}

			if($_POST['action'] == 'delete')
			{
				FlashInfo::add(___('jobs.admin.delete.success', 'many'), 'success');
			}
			elseif($_POST['action'] == 'approve')
			{
				FlashInfo::add(___('jobs.admin.approve.success', 'many'), 'success');
			}
		}

		$this->redirect_referrer();
	}

	public function action_approve()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		$job->approve();

		FlashInfo::add(___('jobs.admin.approve.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_renew()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Jobs_Renew', array('job' => $job));

		if($form->validate())
		{
			$job->renew_admin($form->date_availability->get_value());

			FlashInfo::add('jobs.admin.renew.success', 'success');
			$this->redirect('/admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs/index',
			$this->template->set_title(___('jobs.admin.renew.title')) => '',
		));

		$this->template->content = View::factory('jobs/admin/renew')
			->set('form', $form);
	}

	public function action_promote()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Jobs_Promote', array('job' => $job));

		if($form->validate())
		{
			$job->values($form->get_values())->save();
			$job->save();

			FlashInfo::add('jobs.admin.promote.success', 'success');
			$this->redirect('/admin/jobs');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs/index',
			$this->template->set_title(___('jobs.admin.promote.title')) => '',
		));

		$this->template->content = View::factory('jobs/admin/promote')
			->set('form', $form);
	}
	
	protected function _get_which()
	{
		return array(
			NULL => ___('jobs.which.all'),
			'standard' => ___('jobs.which.standard'),
			'promoted' => ___('jobs.which.promoted'),
			'not_active' => ___('jobs.which.not_active'),
			'active' => ___('jobs.which.active'),
			'not_approved' => ___('jobs.which.not_approved'),
		);
	}
	
	public function action_rebuild_jobs_categories()
	{
		$model = new Model_Job;
		$jobs = $model->find_all();
		
		foreach($jobs as $job)
		{
			if($job->loaded() AND $job->category_id)
			{
				$job->rebuild_category($job->category_id);
			}
		}
		
		FlashInfo::add('OK');
		$this->redirect('/admin');
	}

}
