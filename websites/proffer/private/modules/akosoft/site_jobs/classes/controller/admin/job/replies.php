<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Job_Replies extends Controller_Admin_Main {

	public function action_index()
	{
		$query_params = $this->request->query();

		$model = new Model_Job_Reply;

		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $model->reset(FALSE)->count_all(),
			'view' => 'pagination/admin',
		));

		$model->with('job');
		$replies = $model->order_by('date_added', 'DESC')->find_all();

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.replies.title' => '/admin/job/replies/index' . URL::query(),
		));

		$this->template->content = View::factory('jobs/admin/replies/index')
			->set('pager', $pager)
			->set('replies', $replies)
			->set('filters', $query_params);
	}

	public function action_show()
	{
		$reply = new Model_Job_Reply();
		$reply->find_by_pk($this->request->param('id'));

		if(!$reply->loaded())
		{
			throw new HTTP_Exception_404;
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.replies.title' => '/admin/job/replies/index',
			'jobs.admin.replies.show.title' => '',
		));

		$this->template->content = View::factory('jobs/admin/replies/show')
			->set('reply', $reply);
	}

	public function action_edit()
	{
		$reply = new Model_Job_Reply((int)$this->request->param('id'));

		if(!$reply->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_Jobs_Reply_Edit', array('reply' => $reply));

		if($form->validate())
		{
			$values = $form->get_values();
			$reply->edit_reply($values);

			FlashInfo::add('jobs.admin.replies.edit.success');
			$this->redirect('admin/job/replies/index');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.replies.title' => '/admin/job/replies/index',
			'jobs.admin.replies.edit.title' => '',
		));

		$this->template->content = View::factory('jobs/admin/replies/edit')
			->set('form', $form);
	}

	public function action_delete()
	{
		$reply = new Model_Job_Reply((int)$this->request->param('id'));

		if(!$reply->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$reply->delete();

		FlashInfo::add(___('jobs.admin.replies.delete.success', 'one'));
		$this->redirect('admin/job/replies/index');
	}

	public function action_many()
	{
		$post_data = $this->request->post();

		if(isset($post_data['replies']) AND isset($post_data['action']))
		{
			foreach($post_data['replies'] as $id)
			{
				$reply = new Model_Job_Reply;
				$reply->find_by_pk($id);

				if($reply->loaded())
				{
					switch($post_data['action'])
					{
						case 'delete':
							$reply->delete();
							break;
					}
				}
			}

			switch($post_data['action'])
			{
				case 'delete':
					FlashInfo::add(___('jobs.admin.replies.delete.success', 'many'), 'success');
					break;
			}
		}
		$this->redirect_referrer();
	}

}
