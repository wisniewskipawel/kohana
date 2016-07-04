<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Controller_Admin_Job_Availabilities extends Controller_Admin_Main {

	public function action_index()
	{
		$availabilities = Model_Job_Availability::factory()->get_admin();

		$form = Bform::factory('Admin_Jobs_Availability_Add');

		$validated = TRUE;

		if ($form->validate())
		{
			Model_Job_Availability::factory()->values($form->get_values())->save();
			
			FlashInfo::add('jobs.admin.availabilities.add.success', 'success');
			$this->redirect('/admin/job/availabilities?add');
		}
		else
		{
			$validated = FALSE;
		}

		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'jobs.module.name'		=> '/admin/jobs',
			'jobs.admin.availabilities.title'	=> '/admin/job/availabilities',
		));

		$this->template->content = View::factory('jobs/admin/availabilities/index')
			->set('availabilities', $availabilities)
			->set('validated', $validated)
			->set('form', $form);
	}

	public function action_edit()
	{
		$type = Model_Job_Availability::factory()
			->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Jobs_Availability_Add', $type->as_array());

		if ($form->validate())
		{
			$type->values($form->get_values())->save();
			FlashInfo::add('jobs.admin.availabilities.edit.success', 'success');
			$this->redirect('/admin/job/availabilities');
		}

		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'jobs.module.name'		=> '/admin/jobs',
			'jobs.admin.availabilities.title'	=> '/admin/job/availabilities',
			'jobs.admin.availabilities.edit.title'	=> '',
		));

		$this->template->content = View::factory('jobs/admin/availabilities/edit')
			->set('form', $form);
	}

	public function action_delete()
	{
		$type = Model_Job_Availability::factory()
			->find_by_pk($this->request->param('id'));
		
		$type->delete();
		
		FlashInfo::add('jobs.admin.availabilities.delete.success', 'success');
		$this->redirect_referrer();
	}
	
}
