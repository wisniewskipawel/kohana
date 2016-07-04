<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Product_Availabilities extends Controller_Admin_Main {

	public function action_index()
	{
		$availabilities = ORM::factory('Product_Availability')->get_admin();

		$form = Bform::factory('Admin_Product_Availability_Add');

		$validated = TRUE;

		if ($form->validate())
		{
			ORM::factory('product_Availability')->values($form->get_values())->save();
			
			FlashInfo::add(___('products.admin.availabilites.add.success'), 'success');
			$this->redirect('/admin/product/availabilities?add');
		}
		else
		{
			$validated = FALSE;
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			$this->set_title(___('products.admin.availabilites.index.title'))	=> '/admin/product/availabilities'
		));

		$this->template->content = View::factory('admin/products/availabilities/index')
				->set('availabilities', $availabilities)
				->set('validated', $validated)
				->set('form', $form);
	}

	public function action_edit()
	{
		$type = ORM::factory('product_Availability')->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Product_Availability_Add', $type->as_array());

		if ($form->validate())
		{
			$type->values($form->get_values())->save();
			FlashInfo::add(___('products.admin.availabilites.edit.success'), 'success');
			$this->redirect('/admin/product/availabilities');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			'products.admin.availabilites.index.title'	=> '/admin/product/availabilities',
			$this->set_title(___('products.admin.availabilites.edit.title'))		=> ''
		));

		$this->template->content = View::factory('admin/products/availabilities/edit')
				->set('form', $form);
	}

	public function action_delete()
	{
		ORM::factory('Product_Availability')->where('id', '=', $this->request->param('id'))->find()->delete();
		FlashInfo::add(___('products.admin.availabilites.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
}
