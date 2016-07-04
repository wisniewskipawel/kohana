<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Offer_Categories extends Controller_Admin_Main {

	public function action_add()
	{
		$form = Bform::factory('Admin_Offer_Category_Add');

		if ($form->validate())
		{
			$category_parent_id = $this->request->param('id', $this->request->query('parent_id'));

			$parent_category = ORM::factory('Offer_Category', $category_parent_id ? $category_parent_id : 1);

			$category = new Model_Offer_Category;
			$category->add_category($parent_category, $form->get_values(), $form->get_files());

			FlashInfo::add(___('offers.admin.categories.add.success'), 'success');
			$this->redirect('/admin/offer/categories/add');
		}

		$this->template->content = View::factory('admin/offers/categories/add')
				->set('form', $form);

		breadcrumbs::add(array(
			'homepage'			=> '/',
			'offers.title'			=> '/admin/offers',
			'offers.admin.categories.index.title'	=> '/admin/offer/categories',
			$this->set_title(___('offers.admin.categories.add.title'))	=> '/admin/offer/categories/add'
		)) ;
	}

	public function action_index()
	{
		$categories = ORM::factory('Offer_Category')->get_list($this->request->param('id', 1));

		$category = ORM::factory('Offer_Category')->where('category_id', '=', $this->request->param('id', 1))->find();

		$breadcrumbs = array(
			'homepage'			=> '/',
			'offers.title'			=> '/admin/offers',
			$this->set_title(___('offers.admin.categories.index.title'))	=> '/admin/offer/categories/index',
		);
		
		if ($category->category_id)
		{
			list($bc, $categories_ids) = offers::breadcrumbs($category, TRUE);
		}
		else
		{
			$bc = array();
		}
		
		$breadcrumbs = Arr::merge($breadcrumbs, $bc);
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('admin/offers/categories/index')
				->set('categories', $categories)
				->set('category', $category);
	}

	public function action_ordering()
	{
		$query = $this->request->query();
		
		if (isset($query['next']))
		{
			$next = ORM::factory("Offer_Category")->where('category_id', '=', $query['next'])->find();
			$current = ORM::factory("Offer_Category")->where('category_id', '=', $this->request->param('id'))->find();

			$current->move_to_next_sibling($next);

		}
		elseif (isset($query['prev']))
		{
			$prev = ORM::factory("Offer_Category")->where('category_id', '=', $query['prev'])->find();
			$current = ORM::factory("Offer_Category")->where('category_id', '=', $this->request->param('id'))->find();

			$current->move_to_prev_sibling($prev);
		}

		ORM::factory("Offer_Category", 1)->rebuild_tree();
		$this->redirect_referrer();
	}

	public function action_delete()
	{
		ORM::factory('Offer_Category')->where('category_id','=', $this->request->param('id'))->find()->delete();
		FlashInfo::add(___('offers.admin.categories.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_edit()
	{
		$category = Model_Offer_Category::factory()
			->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Offer_Category_Edit', array('category' => $category));

		if ($form->validate())
		{
			$category->edit_category($form->get_values(), $form->get_files());
			FlashInfo::add(___('offers.admin.categories.edit.success'), 'success');
			$this->redirect('/admin/offer/categories/index/');
		}

		breadcrumbs::add(array(
			'homepage'			=> '/',
			'offers.title'			=> '/admin/offers',
			'offers.admin.categories.index.title'	=> '/admin/offer/categories/index',
			$this->set_title(___('offers.admin.categories.edit.title'))	=> '',
		));

		$this->template->content = View::factory('admin/offers/categories/edit')
				->set('form', $form);
	}

	public function action_delete_image()
	{
		$category = new Model_Offer_Category;
		$category->find_by_pk($this->request->param('id'));
		$category->delete_image();

		FlashInfo::add(___('images.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete_icon()
	{
		$category = new Model_Offer_Category;
		$category->find_by_pk($this->request->param('id'));

		if(!$category->loaded())
			throw new HTTP_Exception_404;

		offers::get_category_icon_manager()->delete($category->pk());

		FlashInfo::add(___('offers.admin.categories.delete_icon.success'));
		$this->redirect_referrer();
	}

}
