<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Job_Comments extends Controller_Admin_Main {

	public function action_index()
	{
		$query_params = $this->request->query();

		$model = new Model_Job_Comment;

		$pager = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $model->reset(FALSE)->count_all(),
			'view' => 'pagination/admin',
		));

		$model->with('job');
		$comments = $model->order_by('date_added', 'DESC')->find_all();

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.comments.title' => '/admin/job/comments/index' . URL::query(),
		));

		$this->template->content = View::factory('jobs/admin/comments/index')
			->set('pager', $pager)
			->set('comments', $comments)
			->set('filters', $query_params);
	}

	public function action_show()
	{
		$comment = new Model_Job_Comment();
		$comment->find_by_pk($this->request->param('id'));

		if(!$comment->loaded())
		{
			throw new HTTP_Exception_404;
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.comments.title' => '/admin/job/comments/index',
			'jobs.admin.comments.show.title' => '',
		));

		$this->template->content = View::factory('jobs/admin/comments/show')
			->set('comment', $comment);
	}

	public function action_edit()
	{
		$comment = new Model_Job_Comment((int)$this->request->param('id'));

		if(!$comment->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_Jobs_Comment_Edit', array('comment' => $comment));

		if($form->validate())
		{
			$values = $form->get_values();
			$comment->edit_comment($values);

			FlashInfo::add('jobs.admin.comments.edit.success');
			$this->redirect('admin/job/comments/index');
		}

		breadcrumbs::add(array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.comments.title' => '/admin/job/comments/index',
			'jobs.admin.comments.edit.title' => '',
		));

		$this->template->content = View::factory('jobs/admin/comments/edit')
			->set('form', $form);
	}

	public function action_delete()
	{
		$comment = new Model_Job_Comment((int)$this->request->param('id'));

		if(!$comment->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$comment->delete();

		FlashInfo::add(___('jobs.admin.comments.delete.success', 'one'));
		$this->redirect('admin/job/comments/index');
	}

	public function action_many()
	{
		$post_data = $this->request->post();

		if(isset($post_data['comments']) AND isset($post_data['action']))
		{
			foreach($post_data['comments'] as $id)
			{
				$comment = new Model_Job_Comment;
				$comment->find_by_pk($id);

				if($comment->loaded())
				{
					switch($post_data['action'])
					{
						case 'delete':
							$comment->delete();
							break;
					}
				}
			}

			switch($post_data['action'])
			{
				case 'delete':
					FlashInfo::add(___('jobs.admin.comments.delete.success', 'many'), 'success');
					break;
			}
		}
		$this->redirect_referrer();
	}

}
