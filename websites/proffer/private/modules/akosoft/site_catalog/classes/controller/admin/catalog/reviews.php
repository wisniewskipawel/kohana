<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Catalog_Reviews extends Controller_Admin_Main {
	
	public function action_index()
	{
		$review = new Model_Catalog_Company_Review;
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> 20,
			'total_items'		=> $review->reset(FALSE)->count_all(),
			'view'			 => 'pagination/admin',
		));

		$reviews = $review
			->with('company')
			->order_by('date_created', 'DESC')
			->find_all();
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			$this->set_title(___('catalog.admin.reviews.title'))	=> '/admin/catalog/reviews'
		));

		$this->template->content = View::factory('admin/catalog/reviews/index')
				->set('reviews', $reviews)
				->set('pager', $pager);
	}
	
	public function action_show()
	{
		$review = new Model_Catalog_Company_Review();
		$review->find_by_pk($this->request->param('id'));

		if(!$review->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.reviews.title' => '/admin/catalog/reviews',
			$this->set_title(___('catalog.admin.reviews.show.title')) => '',
		));
		
		$this->template->content = View::factory('admin/catalog/reviews/show')
			->set('review', $review);
	}
	
	public function action_status()
	{
		$review = new Model_Catalog_Company_Review((int)$this->request->param('id'));
		
		if(!$review->loaded())
			throw new HTTP_Exception_404;
		
		$review->change_status($this->request->query('status'));
		
		$review->send_new_review();
		
		FlashInfo::add(___('catalog.admin.reviews.change_status.success'), 'success');
		$this->redirect_referrer();
	}
	
	public function action_edit()
	{
		$review = new Model_Catalog_Company_Review((int)$this->request->param('id'));
		
		if(!$review->loaded())
			throw new HTTP_Exception_404;
		
		$form = Bform::factory('Admin_Catalog_Reviews_Edit', array('review' => $review));
		
		if($form->validate())
		{
			$values = $form->get_values();
			$review->edit_review($values);
			
			FlashInfo::add(___('catalog.admin.reviews.edit.success'), 'success');
			$this->redirect('admin/catalog/reviews/index');
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'catalog.title'	=> '/admin/catalog',
			'catalog.admin.reviews.title' => '/admin/catalog/reviews',
			$this->set_title(___('catalog.admin.reviews.edit.title')) => '',
		));
		
		$this->template->content = View::factory('admin/catalog/reviews/edit')
				->set('review', $review)
				->set('form', $form);
	}
	
	public function action_delete()
	{
		$review = new Model_Catalog_Company_Review((int)$this->request->param('id'));
		
		if(!$review->loaded())
			throw new HTTP_Exception_404;
		
		$review->delete();
		
		FlashInfo::add(___('catalog.admin.reviews.delete.success.one'), 'success');
		$this->redirect_referrer();
	}

	public function action_many()
	{
		$post_data = $this->request->post();

		if (isset($post_data['ids']) AND isset($post_data['action']))
		{
			foreach ($post_data['ids'] as $id)
			{
				$review = new Model_Catalog_Company_Review;
				$review->find_by_pk($id);
				
				if($review->loaded())
				{
					switch($post_data['action'])
					{
						case 'delete':
							$review->delete();
							break;

						case 'approve':
							$review->change_status(Model_Catalog_Company_Review::STATUS_ACTIVE);
							$review->send_new_review();
							break;
					}
				}
			}
			
			switch($post_data['action'])
			{
				case 'delete':
					FlashInfo::add(___('catalog.admin.reviews.delete.success.many'), 'success');
					break;

				case 'approve':
					FlashInfo::add(___('catalog.admin.reviews.approve.success.many'), 'success');
					break;
			}
		}
		$this->redirect_referrer();
	}
	
}
