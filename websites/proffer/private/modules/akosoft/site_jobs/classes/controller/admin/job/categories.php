<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Job_Categories extends Controller_Admin_Main {

	public function action_index()
	{
		if($this->request->param('id'))
		{
			$category = Model_Job_Category::factory()
				->find_by_pk($this->request->param('id'));
		}
		else
		{
			$category = Model_Job_Category::root();
		}
		
		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$categories = Model_Job_Category::factory()->get_list($category->pk());

		$breadcrumbs = $this->_breadcrumbs($category);
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/admin/categories/index')
			->set('categories', $categories)
			->set('category', $category);
	}

	public function action_add()
	{
		$parent_category = NULL;
		
		if($parent_id = $this->request->query('parent_id'))
		{
			$parent_category = Model_Job_Category::factory()
				->find_by_pk($parent_id);

			if(!$parent_category->loaded())
			{
				throw new HTTP_Exception_404;
			}
		}
		
		$form = Bform::factory('Admin_Jobs_Category_Add', array(
			'parent_id' => $parent_id,
		));

		if($form->validate())
		{
			$values = $form->get_values();
			
			if($values['category_parent_id'])
			{
				$parent_category = Model_Job_Category::factory()
					->find_by_pk($values['category_parent_id']);
			}
			else
			{
				$parent_category = Model_Job_Category::root();
			}

			$category = Model_Job_Category::factory()
				->values($values)
				->insert_as_last_child($parent_category);

			FlashInfo::add('jobs.admin.categories.add.success', 'success');
			$this->redirect('/admin/job/categories/index/' . $category->category_parent_id);
		}

		$this->template->content = View::factory('jobs/admin/categories/add')
			->set('form', $form);
		
		$breadcrumbs = array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			'jobs.admin.categories.title' => '/admin/job/categories',
		);
		$breadcrumbs[$this->template->set_title(___('jobs.admin.categories.add.title'))] = '/admin/job/categories/add';
		breadcrumbs::add($breadcrumbs);
	}

	public function action_edit()
	{
		$category = Model_Job_Category::factory()
			->find_by_pk($this->request->param('id'));
		
		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_Jobs_Category_Edit', array('category' => $category));

		if($form->validate())
		{
			$category->values($form->get_values())->save();

			$files = $form->get_files();

			if(isset($files['image']))
			{
				$category->save_image($files['image']);
			}

			FlashInfo::add('jobs.admin.categories.edit.success', 'success');

			$this->redirect('/admin/job/categories/index/' . $category->category_id);
		}
		
		$breadcrumbs = $this->_breadcrumbs($category);
		$breadcrumbs[$this->template->set_title(___('jobs.admin.categories.edit.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/admin/categories/edit')
			->set('form', $form);
	}

	public function action_ordering()
	{
		$category = Model_Job_Category::factory()->find_by_pk($this->request->param('id'));
		
		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		if(isset($_GET['next']))
		{
			$next = Model_Job_Category::factory()->where('category_id', '=', $_GET['next'])->find();

			$category->move_to_next_sibling($next);
		}
		elseif(isset($_GET['prev']))
		{
			$prev = Model_Job_Category::factory()->where('category_id', '=', $_GET['prev'])->find();

			$category->move_to_prev_sibling($prev);
		}

		Model_Job_Category::root()->rebuild_tree();
		$this->redirect_referrer();
	}

	public function action_delete()
	{
		$category = Model_Job_Category::factory()
			->find_by_pk($this->request->param('id'));
		
		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$category->delete();

		FlashInfo::add('jobs.admin.categories.delete.success', 'success');
		$this->redirect_referrer();
	}

	public function action_delete_image()
	{
		$category = Model_Job_Category::factory()
			->find_by_pk($this->request->param('id'));

		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$category->delete_image();

		FlashInfo::add(___('jobs.admin.categories.delete_image.success'), 'success');
		$this->redirect_referrer();
	}
	
	protected function _breadcrumbs(Model_Job_Category $category = NULL)
	{
		$breadcrumbs = array(
			'homepage' => '/admin',
			'jobs.module.name' => '/admin/jobs',
			$this->template->set_title(___('jobs.admin.categories.title')) => '/admin/job/categories/index',
		);

		if($category AND $category->loaded())
		{
			$categories = Model_Job_Category::factory()->get_path($category);
			
			foreach($categories as $parent_category)
			{
				if(!$parent_category->is_root())
				{
					$breadcrumbs[$parent_category->category_name] = '/admin/job/categories/index/'.$parent_category->pk();
				}
			}
		}
		
		return $breadcrumbs;
	}

}
