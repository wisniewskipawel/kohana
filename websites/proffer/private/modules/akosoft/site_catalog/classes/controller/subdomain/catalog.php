<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Subdomain_Catalog extends Controller_Subdomain_Base {
	
	public function action_index()
	{
		breadcrumbs::add(array(
			$this->_company->company_name => catalog::url($this->_company),
		));
		
		$this->template->action_tab = 'about';
		$this->template->content = View::factory('company/index');
	}
	
	public function action_gallery()
	{
		breadcrumbs::add(array(
			$this->_company->company_name => catalog::url($this->_company),
			$this->set_title(___('catalog.subdomain.gallery.title')) => '',
		));
		
		$this->template->action_tab = 'gallery';
		$this->template->content = View::factory('company/gallery')
			->set('images', $this->_company->get_images());
	}
	
	public function action_contact()
	{
		breadcrumbs::add(array(
			$this->_company->company_name => catalog::url($this->_company),
			$this->set_title(___('catalog.subdomain.contact.title')) => '',
		));
		
		$form = Bform::factory('Frontend_Catalog_SendMessage');
		
		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_company');
			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
			));
			$email->send($this->_company->company_email, array(
				'reply_to' => $form->email->get_value(),
			));
			
			FlashInfo::add(___('catalog.companies.send.success'), 'success');
			$this->redirect_referrer();
		}
		
		$this->template->action_tab = 'contact';
		$this->template->content = View::factory('company/contact')
			->set('form', $form);
	}
	
	public function action_reviews()
	{
		$pagination_comments = Pagination::factory(array(
				'total_items' => Model_Catalog_Company_Review::count_comments_by_company($this->_company),
				'items_per_page' => 10,
			));

		$comments = Model_Catalog_Company_Review::find_comments_by_company($this->_company, $pagination_comments);

		$this->template->styles = array('media/catalog/css/catalog.css');
		$this->template->action_tab = 'reviews';
		$this->template->content = View::factory('company/reviews')
			->set('pagination_comments', $pagination_comments)
			->set('comments', $comments);
		
		$this->set_title(___('catalog.reviews.title'));
	}

	public function action_review_add()
	{
		$form = Bform::factory('Frontend_Catalog_Company_Reviews_Add');

		if($form->validate())
		{
			$values = $form->get_values();

			$review = new Model_Catalog_Company_Review();
			$review->add_review($this->_company, $values);

			if($review->status == Model_Catalog_Company_Review::STATUS_ACTIVE)
			{
				FlashInfo::add(___('catalog.reviews.add.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('catalog.reviews.add.success', 'moderate'), 'success');
			}

			$review->send_new_review();

			$this->redirect(catalog::url($this->_company));
		}

		$this->template->content = View::factory('company/reviews/add')
			->set('form', $form);
		$this->template->action_tab = 'reviews';

		$this->set_title(___('catalog.reviews.add.title'));
	}
	
	public function action_pages()
	{
		$pages = $this->template->get_pages();
		
		foreach($pages as $page)
		{
			if($page['page'] == $this->request->param('page'))
			{
				Events::fire_once($page['module'], Arr::get($page, 'handler', 'catalog/show_company/pages/'.$page['page']), array(
					'controller' => $this,
					'company' => $this->_company,
				));
				return;
			}
		}
		
		throw new HTTP_Exception_404;
	}
	
}
