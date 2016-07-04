<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Profile_Offers extends Controller_Profile_Main {
	
	public function action_my() 
	{
		$filters = $this->request->query();
		$filters['user'] = $this->_current_user;
		$filters['status_choose'] = TRUE;
		
		$offer = new Model_Offer;
		$offer->prepare_list_query($filters, FALSE);
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $offer->count_all(),
		));
		
		$offers = $offer->get_list($pager, $filters, array(
			Arr::get($filters, 'sort_by', 'status') =>Arr::get($filters, 'sort_direction', 'asc')
		));
		
		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('offers.profile.my.title')) => ''
		));

		$this->template->content = View::factory('profile/offers/my')
				->set('offers', $offers)
				->set('pager', $pager)
				->set('filters_sorters', $filters);
	}

	public function action_delete() 
	{
		$offer = ORM::factory('Offer')->get_user_offer($this->request->param('id'), $this->_session->get('user_id'));

		if ( ! $offer->loaded())
			throw new HTTP_Exception_404();

		$offer->delete();

		FlashInfo::add('offers.profile.delete.success', 'success');

		$this->redirect_referrer();
	}

	public function action_statistics() 
	{
		$offer = ORM::factory('Offer')->get_user_offer($this->request->param('id'), $this->_session->get('user_id'));
		
		if ( ! $offer->loaded())
			throw new HTTP_Exception_404();

		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			'offers.profile.my.title' => Route::url('site_offers/profile/offers/my'),
			$this->template->set_title(___('offers.profile.statistics.title'))	=> ''
		));

		$this->template->content = View::factory('profile/offers/statistics')
				->set('offer', $offer);
	}

	public function action_renew() 
	{
		$offer = ORM::factory('Offer')
			->get_user_offer($this->request->param('id'), $this->_session->get('user_id'));

		if ( ! $offer->loaded())
			throw new HTTP_Exception_404(404);
		
		if(!$offer->can_renew())
		{
			$days_left = $offer->get_days_left() - 10;
			FlashInfo::add(___('offers.profile.renew.error_days_left', $days_left, array(
				':days_left' => $days_left,
			)), FlashInfo::ERROR);
			
			$this->redirect_referrer();
		}

		$form = Bform::factory('Profile_Offer_Renew', array('offer' => $offer));
		
		if ($form->validate()) 
		{
			$offer->renew($form->get_values());
			
			FlashInfo::add(___('offers.profile.renew.success'), 'success');
			$this->redirect(Route::url('site_offers/profile/offers/my', array(), 'http'));
		}

		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			'offers.profile.my.title' => Route::url('site_offers/profile/offers/my'),
			$this->template->set_title(___('offers.profile.renew.title')) => ''
		));

		$this->template->content = View::factory('profile/offers/renew')
				->set('form', $form);
	}

	public function action_closet()
	{
		$query = $this->request->query();
		
		$offer = new Model_Offer;
		$offer->filter_by_closet_user($this->_current_user);
		
		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($query, 'on_page', 20),
			'total_items'		=> $offer->reset(FALSE)->count_all(),
		));
		
		$offers = $offer->apply_sorting(array(
			Arr::get($query, 'sort_by') =>Arr::get($query, 'sort_direction', 'asc')
		))->get_list($pager);
		
		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			$this->template->set_title(___('offers.profile.closet.title'))	=> ''
		));

		$this->template->content = View::factory('profile/offers/closet')
				->set('offers', $offers)
				->set('pager', $pager)
				->set('filters_sorters', $query);
	}
	
	public function action_add_to_closet() 
	{
		$offer = ORM::factory('Offer')->get_by_id($this->request->param('id'));

		if ( ! $offer->pk())
			throw new HTTP_Exception_404();

		$offer->add_to_closet($this->_session->get('user_id'));

		FlashInfo::add(___('offers.profile.closet.add.success'), 'success', TRUE);

		$this->redirect(Route::url('site_offers/frontend/offers/show', array(
			'offer_id' => $offer->pk(), 
			'title' => URL::title($offer->offer_title)
		), 'http'));
	}

	public function action_delete_from_closet() 
	{
		ORM::factory('Offer_To_User')
			->where('user_id', '=', $this->_session->get('user_id'))
			->where('offer_id', '=', $this->request->param('id'))
			->find()->delete();

		FlashInfo::add(___('offers.profile.delete.success'), 'success');
		$this->redirect_referrer();
	}

	public function action_edit()
	{
		$offer = ORM::factory('Offer')->get_user_offer($this->request->param('id'), $this->_session->get('user_id'));

		if ( ! $offer->loaded())
			throw new HTTP_Exception_404();

		$form = Bform::factory('Profile_Offer_Edit', array('offer' => $offer));

		if ($form->validate()) 
		{
			$offer->edit_offer($form->get_values());
			FlashInfo::add(___('offers.profile.edit.success'), 'success');
			$this->redirect(Route::url('site_offers/profile/offers/my', NULL, 'http'));
		}

		$images = $offer->get_images();

		$form_images = Bform::factory('Profile_Offer_Images', array('images' => $images));

		if ($form_images->validate()) 
		{
			foreach ($form_images->get_files() as $i) 
			{
				$offer->add_image($i);
			}
			
			FlashInfo::add(___('images.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			'offers.profile.my.title' => Route::url('site_offers/profile/offers/my'),
			$this->template->set_title(___('offers.profile.edit.title')) => ''
		));

		$this->template->content = View::factory('profile/offers/edit')
				->set('offer', $offer)
				->set('form', $form)
				->set('images', $images)
				->set('form_images', $form_images);
	}

	public function action_delete_image() 
	{
		$offer = (new Model_Offer())->get_user_offer($this->request->param('offer_id'), $this->_current_user->pk());

		if(!$offer->loaded())
			throw new HTTP_Exception_404();

		if($image = $offer->get_images()->find_by_id($this->request->param('image_id')))
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

	public function action_coupons()
	{
		$offer = ORM::factory('Offer')->get_user_offer($this->request->param('id'), $this->_session->get('user_id'));

		if ( ! $offer->loaded())
			throw new HTTP_Exception_404();
		
		$coupon = new Model_Coupon_Owner;
		$coupon->filter_by_offer($offer);
		
		$pagination = Pagination::factory(array(
			'items_per_page' => 20,
			'total_items' => $coupon->reset(FALSE)->count_all(),
		));
		
		breadcrumbs::add(array(
			'homepage'	=> '/',
			'profile'		=> Route::url('site_profile/frontend/profile/index'),
			'offers.profile.my.title' => Route::url('site_offers/profile/offers/my'),
			$this->template->set_title(___('offers.profile.coupons.title'))	=> '',
		));
		
		$this->template->content = View::factory('profile/offers/coupons')
			->set('coupons', $coupon->set_pagination($pagination)->order_by('date_created', 'DESC')->find_all())
			->set('pagination', $pagination);
	}
	
}
