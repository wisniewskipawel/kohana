<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Controller_Admin_Product_Categories extends Controller_Admin_Main {
	
	public function action_index()
	{
		$category_id = $this->request->param('id', 1);
		$category = (new Model_Product_Category())->find_by_pk($category_id);
		$categories = $category->find_childrens_for_admin();
		
		$breadcrumbs = $this->breadcrumb_category($category);
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('admin/products/categories/index')
			->set('categories', $categories)
			->set('category', $category);
	}
	
	public function action_add()
	{
		$form = Bform::factory(new Form_Admin_Product_Category_Add(), array(
			'category_parent_id' => $this->request->param('id', $this->request->query('parent_id')),
		));

		if ($form->validate())
		{
			$values = $form->get_values();

			$parent_category = (new Model_Product_Category())->find_by_pk($values['category_parent_id']);
			
			(new Model_Product_Category())->add_category($parent_category, $values);
			
			FlashInfo::add(___('products.admin.categories.add.success'), 'success');
			$this->redirect('/admin/product/categories/index/'.$parent_category->pk());
		}
		
		$this->template->content = View::factory('admin/catalog/categories/add')
			->set('form', $form);
		
		breadcrumbs::add(array(
			___('homepage') => '/admin',
			___('products.title') => '/admin/products',
			___('products.admin.categories.title') => '/admin/product/categories',
			$this->set_title(___('products.admin.categories.add.title')) => '/admin/product/categories/add',
		));
	}

	public function action_edit()
	{
		$category = (new Model_Product_Category())
			->find_by_pk($this->request->param('id'));
		
		$form = Bform::factory(new Form_Admin_Product_Category_Edit(), array(
			'category' => $category
		));
		
		if ($form->validate())
		{
			$category->values($form->get_values())->save();

			$files = $form->get_files();

			if(!empty($files['icon']))
			{
				Products::get_category_icon_manager()
					->save_image($files['icon'], $category->pk());
			}

			FlashInfo::add(___('products.admin.categories.edit.success'), 'success');
			$this->redirect_referrer();
		}
		
		$breadcrumbs = $this->breadcrumb_category($category);
		$breadcrumbs[$this->set_title(___('products.admin.categories.edit.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('admin/products/categories/edit')
			->set('form', $form);
	}
	
	public function action_ordering()
	{
		$query = $this->request->query();
		$current = (new Model_Product_Category())->find_by_pk($this->request->param('id'));
		
		if (isset($query['next']))
		{	
			$next = (new Model_Product_Category())->find_by_pk($query['next']);
			
			$current->move_to_next_sibling($next);   
		}
		elseif (isset($query['prev']))
		{	
			$prev = (new Model_Product_Category())->find_by_pk($query['prev']);
			
			$current->move_to_prev_sibling($prev);
		}
		
		FlashInfo::add(___('products.admin.categories.ordering.success'), 'success');
		(new Model_Product_Category())->find_by_pk(1)->rebuild_tree();
		
		$this->redirect_referrer();
	}

	public function action_delete()
	{
		$category = (new Model_Product_Category())->find_by_pk($this->request->param('id'));

		$category->delete();
		
		FlashInfo::add(___('products.admin.categories.delete.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete_icon()
	{
		$category = Model_Product_Category::factory()
			->find_by_pk($this->request->param('id'));

		if(!$category->loaded())
			throw new HTTP_Exception_404;

		Products::get_category_icon_manager()->delete($category->pk());

		FlashInfo::add(___('products.admin.categories.delete_icon.success'));
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
				$c = (new Model_Product_Category())->find_by_pk($id);
				if ($action == 'delete')
				{
					$c->delete();
					FlashInfo::add(___('products.admin.categories.delete.success', 'many'), 'success');
				}
			}
		}
		$this->redirect_referrer();
	}
	
	public function action_rebuild()
	{
		$category = new Model_Product_Category(1);
		$category->rebuild_tree();
		
		FlashInfo::add('OK');
		
		$this->redirect('admin/product/companies');
	}

	protected function breadcrumb_category(Model_Product_Category $category)
	{
		$breadcrumbs = array(
			___('homepage') => '/admin',
			___('products.title') => '/admin/catalog',
			$this->set_title(___('products.admin.categories.title')) => '/admin/product/categories/index',
		);

		foreach((new Model_Product_Category())->get_path($category) as $category)
		{
			if(!$category->is_root())
			{
				$breadcrumbs[$category->category_name] = '/admin/product/categories/index/' . $category->pk();
			}
		}

		return $breadcrumbs;
	}

}
