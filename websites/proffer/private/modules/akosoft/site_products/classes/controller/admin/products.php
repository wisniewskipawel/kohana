<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Admin_Products extends Controller_Admin_Main {

	public function action_add()
	{
		$form = Bform::factory('Admin_product_Add');

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['product_is_approved'] = TRUE;
			
			ORM::factory('product')->add_product($values, $form->get_files());
			
			FlashInfo::add(___('products.admin.add.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			$this->set_title(___('products.admin.add.title'))	=> '/admin/products/add',
		));

		$this->template->content = View::factory('admin/products/add')
				->set('form', $form);
	}

	public function action_many()
	{
		$post = $this->request->post();
		
		if (isset($post['products']) AND isset($post['action']))
		{
			foreach ($post['products'] as $id)
			{
				$product = ORM::factory('product', $id);
				if ($post['action'] == 'delete')
				{
					$product->delete();
				}
				elseif ($post['action'] == 'approve')
				{
					$product->approve();
				}
			}

			if ($post['action'] == 'delete')
			{
				FlashInfo::add(___('products.admin.delete.success', 'many'), 'success');
			}
			elseif ($post['action'] == 'approve')
			{
				FlashInfo::add(___('products.admin.approve.success', 'many'), 'success');
			}
		}
		$this->redirect_referrer();
	}

	public function action_index()
	{
		$params = $this->request->query();

		$filters = array();
		if ( ! empty($params['user_id']))
		{
			$filters['user_id'] = $params['user_id'];
		}
		$filters['which'] = $this->request->query('which');

		if(!empty($params['search_pk']))
		{
			$filters['primary_key'] = $params['search_pk'];
		}

		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'		=> ORM::factory('product')->count_admin($filters),
			'view'			 => 'pagination/admin'
		));

		$products = ORM::factory('product')->get_admin($filters, $pager->offset, $pager->items_per_page);

		$breadcrumbs = array(
			'homepage'		=> '/admin',
			$this->set_title(___('products.title'))	=> '/admin/products/index',
		);
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('admin/products/index')
				->set('pager', $pager)
				->set('products', $products)
				->set('filters', $filters);
	}

	public function action_approve()
	{
		$product = ORM::factory('product')->where('product_id', '=', $this->request->param('id'))->find();
		$product->approve();
		
		FlashInfo::add(___('products.admin.approve.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_renew()
	{
		$product = ORM::factory('product')->where('product_id', '=', $this->request->param('id'))->find();

		$form = Bform::factory('Admin_product_Renew', array('product' => $product));

		if ($form->validate())
		{
			$product->renew_admin($form->product_availability->get_value());
			FlashInfo::add(___('products.admin.renew.success'), 'success');
			$this->redirect($this->_session->get('product_admin_list_link', '/admin/products?index'));
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products/index',
			$this->set_title(___('products.admin.renew.title'))	=> '',
		));

		$this->template->content = View::factory('admin/products/renew')
				->set('form', $form);
	}

	public function action_edit()
	{
		$product = (new Model_Product())->find_by_pk($this->request->param('id'));

		$images = $product->get_images();

		$form = Bform::factory('Admin_product_Edit', array('product' => $product));

		if ($form->validate())
		{
			$product->edit_product($form->get_values());
			FlashInfo::add(___('products.admin.edit.success'), 'success');
			$this->redirect('/admin/products?index');
		}

		$form_images = Bform::factory('Admin_product_AddImages', array('images' => $images));

		if ($form_images->validate())
		{
			$product->save_images($form_images->images->get_value());
			FlashInfo::add(___('images.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products/index',
			$this->set_title(___('products.admin.edit.title'))	=> '',
		));

		$this->template->content = View::factory('admin/products/edit')
			->set('product', $product)
			->set('form', $form)
			->set('images', $images)
			->set('form_images', $form_images);
	}

	public function action_delete()
	{
		$model = new Model_Product;
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Delete', array(
			'email' => $model->get_email_address(),
			'delete_text' => $model->product_title,
		));
		
		if($form->validate())
		{
			$form->send_message();
			
			$model->delete();

			FlashInfo::add(___('products.admin.delete.success', 'one'), 'success');
			$this->redirect('admin/products');
		}

		breadcrumbs::add(array(
			'homepage'				=> '/admin',
			'products.title'		=> '/admin/products/index',
			$this->set_title(___('products.admin.delete.title'))	=> '',
		));
		
		$this->template->content = View::factory('admin/products/delete')
			->set('product', $model)
			->set('form', $form);
	}

	public function action_promote()
	{
		$product = ORM::factory('product')->where('product_id', '=', $this->request->param('id'))->find();
		
		$form = Bform::factory('Admin_product_Promote', $product->as_array());

		if ($form->validate())
		{
			$product->values($form->get_values())->save();
			
			FlashInfo::add(___('products.admin.promote.success'), 'success');
			$this->redirect('/admin/products');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products/index',
			$this->set_title(___('products.admin.promote.title'))	=> '',
		));

		$this->template->content = View::factory('admin/products/promote')
				->set('form', $form);
	}

	public function action_settings()
	{
		$config = Kohana::$config->load('modules');

		$form = Bform::factory('Admin_Product_Settings', Products::config());

		if ($form->validate())
		{
			$values = $form->get_values();
			$config->set('site_products', $values);
			FlashInfo::add(___('products.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'products.title'		=> '/admin/products',
			$this->set_title(___('products.admin.settings.title'))	=> '/admin/products/settings',
		));

		$this->template->content = View::factory('admin/products/settings')
				->set('form', $form);
	}

	public function action_payments()
	{
		$config = Kohana::$config->load('modules');
		$params = $config->as_array();

		$module_name = $this->request->query('module_name');

		if ($module_name === 'product_promote')
		{
			$form = Bform::factory('Admin_Product_Payment_Promote', $params);
		}
		elseif ($module_name == 'product_add')
		{
			$form = Bform::factory('Admin_Product_Payment_Add', $params);
		}
		
		if ($form->validate())
		{
			$values = $form->get_values();
			foreach ($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add('Zmiany zostały zapisane!', 'success');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('products.admin.payments.title'))	=> '/admin/products/payments?module_name=' . $module_name,
		));

		$this->template->content = View::factory('admin/products/settings_payment')
				->set('form', $form);
	}
	
	public function action_delete_image()
	{
		$product = (new Model_Product())->find_by_pk($this->request->param('id'));

		if(!$product->loaded())
		{
			throw new HTTP_Exception_404;
		}

		if($image = $product->get_images()->find_by_id($this->request->query('image_id')))
		{
			$image->delete();
		}

		FlashInfo::add(___('images.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function permissions()
	{
		if($this->request->action() == 'delete_image')
		{
			return $this->_auth->permissions('admin/products/edit');
		}
		
		return parent::permissions();
	}

}
