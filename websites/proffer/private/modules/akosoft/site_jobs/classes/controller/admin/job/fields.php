<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Admin_Job_Fields extends Controller_Admin_Main {

	public function action_index()
	{
		$category = (int)$this->request->param('id');

		$fields = Model_Job_Category_Field::factory()->find_all();

		$this->template->content = View::factory('jobs/admin/fields/index')
			->set('fields', $fields);

		breadcrumbs::add(array(
			'homepage' => '/',
			'jobs.module.name' => '/admin/jobs',
			$this->set_title(___('jobs.admin.fields.title')) => '/admin/job/fields/index',
		));
	}

	public function action_category()
	{
		$category = (int)$this->request->param('id');

		$fields_all = Model_Job_Category_Field::factory()->find_all();

		if($category)
		{
			$category = new Model_Job_Category($category);

			if(!$category->loaded())
			{
				throw new HTTP_Exception_404;
			}

			$post_values = $this->request->post();
			if(isset($post_values['submitFieldToCategory']))
			{
				$field = new Model_Job_Category_Field((int)Arr::get($post_values, 'category_field_id'));

				if(!$field->loaded())
				{
					FlashInfo::add(___('jobs.admin.fields.category.error', 'id'), 'error');
				}

				if(!$category->has('fields', $field))
				{
					$category->add('fields', $field);

					FlashInfo::add('jobs.admin.fields.category.success');
				}
			}

			$fields = $category->get_fields();
		}

		$this->template->content = View::factory('jobs/admin/fields/category')
			->set('fields', $fields)
			->set('fields_all', $fields_all)
			->set('category', $category);

		$this->set_title(___('jobs.admin.fields.category.title', array(':category' => $category->category_name)));

		$breadcrumbs = array(
			'homepage' => '/',
			'jobs.module.name' => 'admin/jobs',
		);

		if($category)
		{
			$breadcrumbs = $this->_breadcrumbs($category);
		}

		$breadcrumbs['jobs.admin.fields.title'] = $this->request->uri();
		breadcrumbs::add($breadcrumbs);
	}

	public function action_add()
	{
		$form = Bform::factory('Admin_Jobs_Field_Add');

		if($form->validate())
		{
			$values = $form->get_values();

			$model = new Model_Job_Category_Field;
			$model->add_field($values);

			FlashInfo::add('jobs.admin.fields.add.success');
			$this->redirect('admin/job/fields/index');
		}

		$this->template->content = View::factory('jobs/admin/fields/add')
			->set('form', $form);

		breadcrumbs::add(array(
			'homepage' => '/',
			'jobs.module.name' => 'admin/jobs',
			'jobs.admin.fields.title' => 'admin/job/fields',
			$this->set_title(___('jobs.admin.fields.add.title')) => $this->request->uri(),
		));
	}

	public function action_edit()
	{
		$field = new Model_Job_Category_Field((int)$this->request->param('id'));

		if(!$field->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Admin_Jobs_Field_Edit', array('field' => $field));

		if($form->validate())
		{
			$values = $form->get_values();

			$field->edit_field($values);

			FlashInfo::add('jobs.admin.fields.edit.success');
			$this->redirect('admin/job/fields/index');
		}

		$this->template->content = View::factory('jobs/admin/fields/edit')
			->set('form', $form);

		breadcrumbs::add(array(
			'homepage' => '/',
			'jobs.module.name' => 'admin/jobs',
			'jobs.admin.fields.title' => 'admin/job/fields/index',
			$this->set_title(___('jobs.admin.fields.edit.title')) => $this->request->uri(),
		));
	}

	public function action_remove_from_category()
	{
		$category = new Model_Job_Category((int)$this->request->query('category_id'));
		$field = new Model_Job_Category_Field((int)$this->request->query('field_id'));

		if(!$category->loaded() || !$field->loaded())
		{
			throw new HTTP_Exception_404;
		}

		if($category->has('fields', $field))
		{
			$category->remove('fields', $field);
			FlashInfo::add('jobs.admin.fields.category.delete.success');
		}

		$this->redirect_referrer();
	}

	public function action_delete()
	{
		$field = new Model_Job_Category_Field((int)$this->request->param('id'));

		if(!$field->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$field->delete();
		FlashInfo::add('jobs.admin.fields.delete.success');

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
