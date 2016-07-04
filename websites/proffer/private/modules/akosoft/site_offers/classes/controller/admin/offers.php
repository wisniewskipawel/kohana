<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Offers extends Controller_Admin_Main {
	
	public function action_add()
	{
		$form = Bform::factory('Admin_Offer_Add');
		
		if ($form->validate())
		{
			$values = $form->get_values();
			$values['offer_is_paid'] = TRUE;
			ORM::factory('Offer')->add_offer($values, $form->get_files());
			
			FlashInfo::add(___('offers.admin.add.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'offers.title'	=> '/admin/offers',
			$this->set_title(___('offers.admin.add.title'))	=> '/admin/offers/add'
		));
		
		$this->template->content = View::factory('admin/offers/add')
				->set('form', $form);
	}
	
	public function action_many()
	{
		$post = $this->request->post();
		
		if (isset($post['offers']) AND isset($post['action']))
		{
			foreach ($post['offers'] as $id)
			{
				$offer = ORM::factory('Offer', $id);
				if ($post['action'] == 'delete')
				{
					$offer->delete();
				}
				elseif ($post['action'] == 'approve')
				{
					$offer->approve();
				}
			}
			
			if ($post['action'] == 'delete')
			{
				FlashInfo::add(___('offers.admin.delete.success', 'many'), 'success');
			}
			
			elseif ($post['action'] == 'approve')
			{
				FlashInfo::add(___('offers.admin.approve.success', 'many'), 'success');
			}
		}
		
		$this->redirect_referrer();
	}
	
	public function action_index() 
	{
		$filters = $this->request->query();
		$filters['which'] = $this->request->query('which');

		$pager = Pagination::factory(array(
			'items_per_page'		=> 20,
			'total_items'		   => ORM::factory('Offer')->count_admin($filters),
			'view'				  => 'pagination/admin'
		));

		$offers = ORM::factory('Offer')->get_admin($filters, $pager->offset, $pager->items_per_page);

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			$this->set_title(___('offers.title'))	=> '/admin/offers/index',
		));

		$this->template->content = View::factory('admin/offers/index')
				->set('pager', $pager)
				->set('offers', $offers)
				->set('filters', $filters);
	}

	public function action_approve() 
	{
		$offer = ORM::factory('Offer')->find_by_pk($this->request->param('id'));
		
		if(!$offer->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$offer->approve();
		$offer->send_offer_approved();
		
		FlashInfo::add(___('offers.admin.approve.success', 'one'), 'success');
		$this->redirect_referrer();
	}

	public function action_renew() 
	{
		$offer = ORM::factory('Offer')->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Offer_Renew', array('offer' => $offer));

		if ($form->validate()) 
		{
			$offer->renew($form->get_values());
			
			FlashInfo::add(___('offers.admin.renew.success'), 'success');
			$this->redirect('admin/offers/index');
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'offers.title'	=> '/admin/offers/index',
			$this->set_title(___('offers.admin.renew.title')) => '',
		));

		$this->template->content = View::factory('admin/offers/renew')
				->set('form', $form);
	}

	public function action_edit() 
	{
		$offer = (new Model_Offer())->find_by_pk($this->request->param('id'));
		
		$images = $offer->get_images();

		$form = Bform::factory('Admin_Offer_Edit', Arr::merge($offer->as_array(), array('offer' => $offer)));

		if ($form->validate()) 
		{
			$offer->edit_offer($form->get_values());
			
			FlashInfo::add(___('offers.admin.edit.success'), 'success');
			$this->redirect('admin/offers/index');
		}
		
		$form_images = Bform::factory('Admin_Offer_AddImages', array('images' => $images));
		
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
			'homepage'	=> '/admin',
			'offers.title'	=> '/admin/offers/index',
			$this->set_title(___('offers.admin.edit.title')) => '',
		));

		$this->template->content = View::factory('admin/offers/edit')
			->set('offer', $offer)
			->set('form', $form)
			->set('images', $images)
			->set('form_images', $form_images);
	}

	public function action_delete()
	{
		$model = new Model_Offer;
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$form = Bform::factory('Admin_Delete', array(
			'email' => $model->get_email_address(),
			'delete_text' => $model->offer_title,
		));
		
		if($form->validate())
		{
			$form->send_message();
			
			$model->delete();

			FlashInfo::add(___('offers.admin.delete.success', 'one'), 'success');
			$this->redirect('admin/offers');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'offers.title'	=> '/admin/offers/index',
			$this->set_title(___('offers.admin.delete.title')) => '',
		));
		
		$this->template->content = View::factory('admin/offers/delete')
			->set('offer', $model)
			->set('form', $form);
	}

	public function action_promote() 
	{
		$offer = ORM::factory('Offer')->find_by_pk($this->request->param('id'));

		$form = Bform::factory('Admin_Offer_Promote', array('offer' => $offer));

		if ($form->validate()) 
		{
			$offer->values($form->get_values())->save();
			$offer->save();
			
			FlashInfo::add(___('offers.admin.promote.success'), 'success');
			$this->redirect('admin/offers/index');
		}
		
		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'offers.title'	=> '/admin/offers/index',
			$this->set_title(___('offers.admin.promote.title')) => '',
		));

		$this->template->content = View::factory('admin/offers/promote')
				->set('form', $form);
	}

	public function action_payments()
	{
		$config = Kohana::$config->load('modules');
		$params = $config->as_array();

		$module_name = $this->request->query('module_name');

		if ($module_name === 'offer_promote')
		{
			$form = Bform::factory('Admin_Offer_Payment_Promote', $params);
		}
		elseif ($module_name == 'offer_add')
		{
			$form = Bform::factory('Admin_Offer_Payment_Add', $params);
		}
		
		if ($form->validate())
		{
			$values = $form->get_values();
			foreach ($values as $name => $value)
			{
				$config->set($name, $value);
			}
			FlashInfo::add(___('offers.admin.payments.success'), 'success');
		}

		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('offers.admin.payments.title'))	=> '/admin/offers/payments?module_name=' . $module_name,
		));

		$this->template->content = View::factory('admin/offers/settings_payment')
			->set('form', $form);
	}
	
	public function action_delete_image()
	{
		$offer = (new Model_Offer())->find_by_pk($this->request->param('id'));
		
		if(!$offer->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		if($image = $offer->get_images()->find_by_id($this->request->query('image_id')))
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
			return $this->_auth->permissions('admin/offers/edit');
		}
		
		return parent::permissions();
	}
	
}
