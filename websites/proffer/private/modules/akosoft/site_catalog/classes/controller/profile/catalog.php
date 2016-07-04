<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Profile_Catalog extends Controller_Profile_Main {
	
	public function action_closet()
	{
		$filters = $this->request->query();
		$filters['closet'] = $this->_current_user->pk();
		
		$model_company = new Model_Catalog_Company;
		$model_company->apply_filters($filters);
		
		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => $model_company->count_all(),
		));

		$companies = $model_company->apply_filters($filters)
			->get_list(NULL, $pager->offset, $pager->items_per_page);
		
		breadcrumbs::add(array(
			'homepage'		=> '/',
			'profile'			=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('catalog.profile.closet.title'))		   => ''
		));
		
		$this->template->content = View::factory('profile/catalog/closet')
				->set('pager', $pager)
				->set('companies', $companies)
				->set('filters_sorters', $filters);
	}
	
	public function action_closet_delete()
	{
		$company = new Model_Catalog_Company($this->request->param('id'));
		
		if(!$company->loaded())
			throw new HTTP_Exception_404;
		
		$user_closet = new Model_Catalog_CompanyToUser;
		$user_closet->delete_by_user($this->_current_user, $company);

		FlashInfo::add(___('catalog.profile.closet.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_add_to_closet()
	{
		$company = ORM::factory('Catalog_Company', $this->request->param('id'));
		if ( ! $company->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$company->add_to_closet($this->_current_user->pk());
		FlashInfo::add(___('catalog.profile.closet.add.success'), 'success');
		
		$this->redirect_referrer();
	}
	
	public function action_my() 
	{
		$filters = $this->request->query();
		$filters['user_id'] = $this->_current_user->pk();
		
		$model_company = new Model_Catalog_Company;
		$model_company->apply_filters($filters);
		
		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => $model_company->count_all(),
		));

		$companies = $model_company->apply_filters($filters)
			->get_list(NULL, $pager->offset, $pager->items_per_page);

		breadcrumbs::add(array(
			'homepage'		=> '/',
			'profile'			=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('catalog.profile.my.title'))		   => ''
		));

		$this->template->content = View::factory('profile/catalog/my')
				->set('companies', $companies)
				->set('pager', $pager)
				->set('filters_sorters', $filters);
	}

	public function action_edit_promoted() 
	{
		$company = ORM::factory('Catalog_Company')->get_by_id($this->request->param('id'), $this->_session->get('user_id'));

		if ( ! $company->company_id)
		{
			throw new HTTP_Exception_404(404);
		}

		$categories = $company->get_categories(TRUE);
		$values = $this->request->post();
		
		foreach($categories as $index => &$category)
		{
			$category = isset($values['category'][$index]) ? $values['category'][$index] : $category->pk();
		}

		$images = $company->get_images();
		
		$form_params['company'] = $company;
		$form_params['images'] = $images;
		$form = Bform::factory('Profile_Catalog_Company_Edit', $form_params);

		if ($form->validate())
		{
			$values = $form->get_values();
			$company->edit_company($values, $form->get_files());
			FlashInfo::add(___('catalog.profile.edit.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'		=> '/',
			'profile'			=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('catalog.profile.edit.title'))		   => ''
		));

		$this->template->content = View::factory('profile/catalog/edit_promoted')
				->set('form', $form)
				->set('company', $company)
				->set('categories', $categories)
				->set('images', $images);
	}
	
	public function action_delete_image()
	{
		$company = (new Model_Catalog_Company())
			->get_by_id($this->request->param('company_id'), $this->_current_user->pk());
		
		if(!$company->loaded())
		{
			throw new HTTP_Exception_404;
		}

		if($image = $company->get_images()->find_by_id($this->request->param('image_id')))
		{
			$image->delete();
		}
		
		FlashInfo::add(___('images.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_delete() 
	{
		$company = ORM::factory('Catalog_Company')->get_by_id($this->request->param('id'), $this->_session->get('user_id'));
		
		if(!$company->loaded() OR !$company->is_owner($this->_current_user))
		{
			throw new HTTP_Exception_404;
		}
		
		$company->delete();

		FlashInfo::add(___('catalog.profile.delete.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_promote()
	{
		$company = Model_Catalog_Company::factory()
			->get_by_id($this->request->param('id'), $this->_current_user->pk());

		if (!$company->loaded())
		{
			throw new HTTP_Exception_404;
		}

		breadcrumbs::add(array(
			'homepage'		=> '/',
			'profile'			=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('catalog.profile.promote.title'))	=> ''
		));
		
		$promotion_type = (int)$this->request->query('promotion_type');
		
		if(!$promotion_type)
		{
			$this->template->content = View::factory('profile/catalog/choose_promotion')
				->set('company', $company);
			return;
		}
		
		$types = new Catalog_Company_Promotion_Types();
		$type = $types->get_by_id($promotion_type);
		
		if(!$type OR $type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
		{
			throw new HTTP_Exception_404('Wrong promotion type!');
		}
		
		$payment_module = new Payment_Company_Promote;
		$payment_module->type($type->get_id());
		
		$form = Bform::factory(new Form_Profile_Catalog_Company_Promote(), array(
			'company' => $company,
			'promotion_type' => $type,
			'payment_module' => $payment_module,
			'current_user' => $this->_current_user,
		));

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['promotion_type'] = $type->get_id();
			$values['company_is_promoted'] = FALSE;
			
			$company->edit_company($values);
			
			$payment_module->set_params(array(
				'id' => $company->pk(), 
				'discount' => (bool)Arr::get($values, 'with_discount', FALSE)
			));
			$payment_module->load_object($company);
			$payment_module->pay(Arr::get($values, 'payment_method'));
		}

		$this->template->content = View::factory('profile/catalog/promote')
			->set('payment_module', $payment_module)
			->set('company', $company)
			->set('form', $form);
	}
	
	public function action_prolong_promote()
	{
		$company = Model_Catalog_Company::factory()
			->get_by_id($this->request->param('id'), $this->_session->get('user_id'));

		if (!$company->loaded() OR !$company->can_prolong_promote())
		{
			throw new HTTP_Exception_404;
		}
		
		$payment_module = new Payment_Company_Promote;
		$payment_module->type($company->promotion_type);
		
		$form = Bform::factory('Profile_Catalog_Company_Promote_Prolong', array(
			'company' => $company,
			'payment_module' => $payment_module,
			'current_user' => $this->_current_user,
		));

		if ($form->validate())
		{
			$values = $form->get_values();
			
			$payment_module->set_params(array(
				'id' => $company->pk(), 
				'discount' => (bool)Arr::get($values, 'with_discount', FALSE)
			));
			$payment_module->load_object($company);
			$payment_module->pay(Arr::get($values, 'payment_method'));
		}

		breadcrumbs::add(array(
			'homepage'		=> '/',
			'profile'			=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('catalog.profile.prolong_promote.title'))	=> ''
		));

		$this->template->content = View::factory('profile/catalog/prolong_promote')
			->set('payment_module', $payment_module)
			->set('company', $company)
			->set('form', $form);
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			Media::css('catalog.css', 'catalog/css', array('minify' => TRUE));
			Media::js('catalog.js', 'catalog/js', array('minify' => TRUE));
		}
		
		parent::after();
	}
	
}
