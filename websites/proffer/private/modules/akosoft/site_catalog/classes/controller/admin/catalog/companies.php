<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Admin_Catalog_Companies extends Controller_Admin_Main {
	
	public function after()
	{
		Media::css('catalog.global.css', 'catalog/css');
		
		parent::after();
	}
	
	public function action_index() 
	{
		$filters = $this->request->query();

		$form = Bform::factory('Admin_Catalog_Company_Filters', $filters);

		if ($form->validate())
		{
			$values = $form->get_values();
			$filters = Arr::merge($filters, $values);
		}

		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'		=> ORM::factory('Catalog_Company')->count($filters),
			'view'			=> 'pagination/admin'
		));

		$companies = ORM::factory('Catalog_Company')->get_list_admin($filters, $pager->items_per_page, $pager->offset);
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			$this->set_title(___('catalog.admin.companies.title'))	=> '/admin/catalog/companies/index'
		));

		$this->template->content = View::factory('admin/catalog/companies/index')
				->set('companies', $companies)
				->set('form', $form)
				->set('pager', $pager);
	}
	
	public function action_add()
	{
		$form = Bform::factory('Admin_Catalog_Company_Add');
		
		if ($form->validate())
		{
			$values = $form->get_values();
			
			ORM::factory('Catalog_Company')->add_company_admin($values, $form->get_files());
			FlashInfo::add(___('catalog.admin.companies.add.success'), 'success');
			$this->redirect('/admin/catalog/companies');
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			$this->set_title(___('catalog.admin.companies.add.title'))	=> '/admin/catalog/companies/add',
		));
		
		$this->template->content = View::factory('admin/catalog/companies/add')
				->set('form', $form);
	}
	
	public function action_approve()
	{
		$company = ORM::factory('Catalog_Company', $this->request->param('id'));
		$company->approve();
		
		FlashInfo::add(___('catalog.admin.companies.approve.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_edit()
	{
		$company = ORM::factory('Catalog_Company')->where('company_id', '=', $this->request->param('id'))->find();

		$categories = $company->categories
				->order_by('catalog_categories_to_companies.relation_nb', 'ASC')
				->order_by('catalog_category.category_name', 'ASC')
				->where('catalog_category.category_level', '>', 1)
				->find_all();
		
		$images = $company->get_images();
		
		$logo = $company->get_logo();

		$form = Bform::factory('Admin_Catalog_Company_Edit', array('company' => $company));

		if ($form->validate())
		{
			$company->edit_company_admin($form->get_values());
			FlashInfo::add(___('catalog.admin.companies.edit.success'), 'success');
			$this->redirect_referrer();
		}
		
		$form_images = Bform::factory('Admin_Catalog_Company_AddImages', array('images' => $images));
		
		if ($form_images->validate())
		{
			$photos = $form_images->photos->get_value();
			
			if($photos)
			{
				foreach($photos as $file_path)
				{
					$company->add_photo($file_path);
				}
			}
			
			FlashInfo::add(___('images.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		$form_logo = Bform::factory('Admin_Catalog_Company_Logo', array('logo' => $logo));
		
		if ($form_logo->validate())
		{
			$logo_file = $form_logo->logo->get_value();
			$company->add_logo($logo_file);
			
			FlashInfo::add(___('catalog.admin.companies.edit.logo.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.companies.title'	=> '/admin/catalog/companies/index',
			$this->set_title(___('catalog.admin.companies.edit.title'))	=> ''
		));
		
		$this->template->content = View::factory('admin/catalog/companies/edit')
				->set('form', $form)
				->set('company', $company)
				->set('logo', $logo)
				->set('categories', $categories)
				->set('images', $images)
				->set('form_images', $form_images)
				->set('form_logo', $form_logo);
	}

	public function action_delete()
	{
		$model = new Model_Catalog_Company;
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Delete', array(
			'email' => $model->get_email_address(),
			'delete_text' => $model->company_name,
		));
		
		if($form->validate())
		{
			$form->send_message();
			
			$model->delete();

			FlashInfo::add(___('catalog.admin.companies.delete.success', 'one'), 'success');
			$this->redirect('admin/catalog/companies/index');
		}

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.companies.title'	=> '/admin/catalog/companies/index',
			$this->set_title(___('catalog.admin.companies.delete.title'))	=> ''
		));
		
		$this->template->content = View::factory('admin/catalog/companies/delete')
			->set('company', $model)
			->set('form', $form);
	}

	public function action_delete_logo()
	{
		$model = new Model_Catalog_Company;
		$model->find_by_pk($this->request->param('id'));

		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$model->get_logo_manager()->delete($this->request->query('image_id'));

		FlashInfo::add(___('images.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete_image()
	{
		$model = new Model_Catalog_Company;
		$model->find_by_pk($this->request->param('id'));

		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$model->get_images()->delete($this->request->query('image_id'));

		FlashInfo::add(___('images.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_many()
	{
		$post = $this->request->post();
		
		if ( ! empty($post['companies']))
		{
			foreach ($post['companies'] as $id)
			{
				$company = ORM::factory('Catalog_Company', $id);
				if ( $post['action'] == 'delete')
				{
					$company->delete();
				}
				elseif ($post['action'] == 'approve')
				{
					$company->approve();
				}
			}
		}
		
		if ($post['action'] == 'delete')
		{
			FlashInfo::add(___('catalog.admin.companies.delete.success', 'many'), 'success');
		}
		elseif ($post['action'] == 'approve')
		{
			FlashInfo::add(___('catalog.admin.companies.approve.success', 'many'), 'success');
		}
		
		$this->redirect_referrer();
	}

	public function permissions()
	{
		if(in_array($this->request->action(), array('delete_image', 'delete_logo')))
		{
			return $this->_auth->permissions('admin/catalog/companies/edit');
		}

		return parent::permissions();
	}
	
}
