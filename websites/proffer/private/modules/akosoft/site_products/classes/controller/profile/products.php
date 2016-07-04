<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Controller_Profile_Products extends Controller_Profile_Main {
	
	public function action_my() 
	{
		$filters = $this->request->query();
		$filters['user_id'] = $this->_auth->get_user_id();
		$filters['my'] = TRUE;
		$filters['sort_by'] = Arr::get($filters, 'sort_by', 'id');
		$filters['sort_direction'] = Arr::get($filters, 'sort_direction', 'DESC');
		
		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => ORM::factory('Product')->count_all_list($filters)
		));

		$products = ORM::factory('Product')->get_all($pager->offset, $pager->items_per_page, $filters);

		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('products.profile.my.title')) => ''
		));

		$this->template->content = View::factory('profile/products/my_products')
				->set('products', $products)
				->set('filters_sorters', $filters)
				->set('pager', $pager);
	}

	public function action_delete() 
	{
		$product = ORM::factory('Product')
			->get_user_product($this->request->param('id'), $this->_auth->get_user_id());

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		$product->delete();

		FlashInfo::add(___('products.profile.delete.success'), 'success');

		$this->redirect_referrer();
	}

	public function action_statistics() 
	{
		$product = ORM::factory('Product')
			->get_user_product($this->request->param('id'), $this->_auth->get_user_id());

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		$this->template->content = View::factory('profile/products/statistics')
				->set('product', $product);

		breadcrumbs::add(array(
			'homepage'			=> '/',
			'profile'				=> Route::url('site_profile/frontend/profile/index'),
			'products.profile.my.title'	=> Route::url('site_products/profile/products/my'),
			$this->template->set_title(___('products.profile.statistics.title')) => ''
		));
	}

	public function action_renew() 
	{
		$product = ORM::factory('Product')
			->get_user_product($this->request->param('id'), $this->_auth->get_user_id());

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}
		
		if(!$product->can_renew())
		{
			$days_left = $product->get_availability_days_left() - 10;
			FlashInfo::add(___('products.profile.renew.error_days_left', $days_left, array(
				':days_left' => $days_left,
			)), FlashInfo::ERROR);
			
			$this->redirect_referrer();
		}

		$form = Bform::factory('Profile_Product_Renew');
		
		if ($form->validate()) 
		{
			$product->renew($form->product_availability->get_value());
			
			FlashInfo::add(___('products.profile.renew.success'), 'success');
			$this->redirect(Route::url('site_products/profile/products/my', array(), 'http'));
		}

		breadcrumbs::add(array(
			'homepage'			=> '/',
			'profile'				=> Route::url('site_profile/frontend/profile/index'),
			'products.profile.my.title'	=> Route::url('site_products/profile/products/my'),
			$this->template->set_title(___('products.profile.renew.title')) => ''
		));

		$this->template->content = View::factory('profile/products/renew')
				->set('form', $form);
	}

	public function action_closet()
	{
		$filters = $this->request->query();
		$filters['closet'] = $this->_auth->get_user_id();
		
		$count_products = ORM::factory('Product')->count_all_list($filters);
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $count_products,
		));
		
		$products = ORM::factory('Product')->get_all($pager->offset, $pager->items_per_page, $filters);
		
		breadcrumbs::add(array(
			'homepage'			=> '/',
			'profile'				=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('products.profile.closet.title'))	=> ''
		));

		$this->template->content = View::factory('profile/products/closet')
				->set('products', $products)
				->set('filters_sorters', $filters)
				->set('pager', $pager);
	}
	
	public function action_add_to_closet() 
	{
		$product = ORM::factory('Product')->get_by_id($this->request->param('id'));

		if ( ! $product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		$product->add_to_closet($this->_current_user);

		FlashInfo::add(___('products.profile.closet.add.success'), 'success');

		$this->redirect_referrer();
	}

	public function action_delete_from_closet() 
	{
		$model = ORM::factory('Product_To_User')
			->where('user_id', '=', $this->_auth->get_user_id())
			->where('product_id', '=', $this->request->param('id'))
			->find();

		if (!$model->loaded()) 
		{
			throw new HTTP_Exception_404();
		}
	
		$model->delete();

		FlashInfo::add(___('products.profile.closet.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_edit() 
	{
		$product = (new Model_Product())
			->get_user_product($this->request->param('id'), $this->_auth->get_user_id());

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Profile_Product_Edit', array('product' => $product));

		if ($form->validate()) 
		{
			$product->edit_product($form->get_values());
			FlashInfo::add(___('products.profile.edit.success'), 'success');
			$this->redirect(Route::url('site_products/profile/products/my', NULL, 'http'));
		}

		$images = $product->get_images();
		
		$form_images = Bform::factory('Profile_Product_Images', array('images' => $images));

		if($form_images->validate())
		{
			$product->save_images($form_images->images->get_value());
			FlashInfo::add(___('images.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		$this->template->content = View::factory('profile/products/edit');
		
		breadcrumbs::add(array(
			'homepage'			=> '/',
			'profile'				=> Route::url('site_profile/frontend/profile/index'),
			'products.profile.my.title'	=> Route::url('site_products/profile/products/my'),
			$this->template->set_title(___('products.profile.edit.title')) => ''
		));

		$this->template->content
			->set('product', $product)
			->set('form', $form)
			->set('images', $images)
			->set('form_images', $form_images);
	}

	public function action_delete_image() 
	{
		$product = (new Model_Product())
			->get_user_product($this->request->param('product_id'), $this->_auth->get_user_id());

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		if($image = $product->get_images()->find_by_id($this->request->param('image_id')))
		{
			$image->delete();
			FlashInfo::add(___('images.delete.success'), 'success');
		}
		else
		{
			FlashInfo::add(___('images.delete.error'));
		}

		$this->redirect_referrer();
	}

	public function after()
	{
		if($this->auto_render)
		{
			Media::css('products.css', 'products/css', array('minify' => TRUE));
			Media::js('products.js', 'products/js', array('minify' => TRUE));
		}
		
		parent::after();
	}
	
}
