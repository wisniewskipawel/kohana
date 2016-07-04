<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Catalog_Categories extends Controller_Admin_Main {
	
	public function action_index()
	{
		$categories = ORM::factory('Catalog_Category')->get_list($this->request->param('id', 1));
		$category = ORM::factory('Catalog_Category')->where('category_id', '=', $this->request->param('id', 1))->find();
		
		$breadcrumbs = array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			$this->set_title(___('catalog.admin.categories.title'))	=> '/admin/catalog/categories/index'
		);
		
		$breadcrumbs = Arr::merge($breadcrumbs, catalog::breadcrumbs($category, TRUE));
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('admin/catalog/categories/index')
				->set('categories', $categories)
				->set('category', $category);
	}
	
	public function action_add()
	{
		$form = Bform::factory('Admin_Catalog_Category_Add', array(
			'category_parent_id' => $this->request->param('id', $this->request->query('parent_id')),
		));

		if ($form->validate())
		{
			$values = $form->get_values();
			
			$parent_category = ORM::factory('Catalog_Category', $values['category_parent_id']);
			
			$added = ORM::factory('Catalog_Category')->values($values);
			$added->insert_as_last_child($parent_category);
			ORM::factory('Catalog_Category', 1)->rebuild_tree();
			
			FlashInfo::add(___('catalog.admin.categories.add.success'), 'success');
			$this->redirect('/admin/catalog/categories/add');
		}
		
		$this->template->content = View::factory('admin/catalog/categories/add')
				->set('form', $form);
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.categories.title'	=> '/admin/catalog/categories',
			$this->set_title(___('catalog.admin.categories.add.title'))   => '/admin/catalog/categories/add',
		));
	}

	public function action_edit()
	{
		$category = Model_Catalog_Category::factory()
			->find_by_pk($this->request->param('id'));
		
		$form = Bform::factory('Admin_Catalog_Category_Edit', array(
			'category' => $category
		));
		
		if ($form->validate())
		{
			$category->values($form->get_values())->save();

			$files = $form->get_files();

			if(!empty($files['icon']))
			{
				catalog::get_category_icon_manager()
					->save_image($files['icon'], $category->pk());
			}

			FlashInfo::add(___('catalog.admin.categories.edit.success'), 'success');
			$this->redirect_referrer();
		}
		
		$breadcrumbs = array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.categories.title'	=> '/admin/catalog/categories/index',
		);
		
		$breadcrumbs = Arr::merge($breadcrumbs, catalog::breadcrumbs($category, TRUE));
		$breadcrumbs[$this->set_title(___('catalog.admin.categories.edit.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('admin/catalog/categories/edit')
				->set('form', $form);
	}
	
	public function action_ordering()
	{
		$query = $this->request->query();
		
		if (isset($query['next']))
		{	
			$next = ORM::factory("Catalog_Category")->where('category_id', '=', $query['next'])->find();
			$current = ORM::factory("Catalog_Category")->where('category_id', '=', $this->request->param('id'))->find();
			
			$current->move_to_next_sibling($next);   
		}
		elseif (isset($query['prev']))
		{	
			$prev = ORM::factory("Catalog_Category")->where('category_id', '=', $query['prev'])->find();
			$current = ORM::factory("Catalog_Category")->where('category_id', '=', $this->request->param('id'))->find();
			
			$current->move_to_prev_sibling($prev);
		}
		
		FlashInfo::add(___('catalog.admin.categories.ordering.success'), 'success');
		ORM::factory("Catalog_Category", 1)->rebuild_tree();
		
		$this->redirect_referrer();
	}

	public function action_delete()
	{
		ORM::factory('Catalog_Category')
			->where('category_id', '=', $this->request->param('id'))
			->find()
			->delete();
		
		FlashInfo::add(___('catalog.admin.categories.delete.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete_icon()
	{
		$category = Model_Catalog_Category::factory()
			->find_by_pk($this->request->param('id'));

		if(!$category->loaded())
			throw new HTTP_Exception_404;

		catalog::get_category_icon_manager()->delete($category->pk());

		FlashInfo::add(___('catalog.admin.categories.delete_icon.success'));
		$this->redirect_referrer();
	}
	
	public function action_many()
	{
		$categories = $this->request->post('categories');
		$action = $this->request->post('action');
		
		if ($categories)
		{
			foreach ($categories as $id)
			{
				$c = ORM::factory('Catalog_Category', $id);
				if ($action == 'delete')
				{
					$c->delete();
					FlashInfo::add(___('catalog.admin.categories.delete.success', 'many'), 'success');
				}
			}
		}
		$this->redirect_referrer();
	}
	
	public function action_rebuild()
	{
		$category = new Model_Catalog_Category(1);
		$category->rebuild_tree();
		
		FlashInfo::add('OK');
		
		$this->redirect('admin/catalog/companies');
	}
	
}
