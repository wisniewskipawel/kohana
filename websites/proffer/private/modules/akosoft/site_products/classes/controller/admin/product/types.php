<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Product_Types extends Controller_Admin_Main {

	public function action_index()
	{
		$types = ORM::factory('Product_Type')->get_admin();

		$form = Bform::factory('Admin_Product_Type_Add');

		$validated = TRUE;

		if ($form->validate())
		{
			ORM::factory('Product_Type')->values($form->get_values())->save();
			FlashInfo::add(___('products.admin.types.add.success'), 'success');
			$this->redirect('/admin/product/types?add');
		}
		else
		{
			$validated = FALSE;
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			$this->set_title(___('products.admin.types.index.title'))	=> '/admin/product/types',
		));

		$this->template->content = View::factory('admin/products/types/index')
				->set('types', $types)
				->set('validated', $validated)
				->set('form', $form);
	}

	public function action_edit()
	{
		$type = ORM::factory('Product_Type')->where('id', '=', $this->request->param('id'))->find();

		$form = Bform::factory('Admin_Product_Type_Add', $type->as_array());

		if ($form->validate())
		{
			$type->values($form->get_values())->save();
			FlashInfo::add(___('products.admin.types.edit.success'), 'success');
			$this->redirect('/admin/product/types');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			'products.admin.types.index.title'	=> '/admin/product/types',
			$this->set_title(___('products.admin.types.edit.title'))		=> '',
		));

		$this->template->content = View::factory('admin/products/types/edit')
				->set('form', $form);
	}

	public function action_delete()
	{
		ORM::factory('Product_Type')->where('id', '=', $this->request->param('id'))->find()->delete();
		FlashInfo::add(___('products.admin.types.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
}
