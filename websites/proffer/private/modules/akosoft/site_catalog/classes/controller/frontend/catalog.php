<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Frontend_Catalog extends Controller_Catalog {
	
	public function action_home()
	{
		breadcrumbs::add($this->_breadcrumb());
		
		$this->template->content = View::factory('frontend/catalog/home');
	}
	
	public function action_pre_add()
	{
		if (Modules::enabled('site_documents')) 
		{
			$document = Pages::get('catalog_add_company');
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('catalog.companies.add.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);

		$types = new Catalog_Company_Promotion_Types();
		
		$this->template->content = View::factory('frontend/catalog/pre_add')
			->bind('document', $document)
			->set('types', $types->get_enabled());
	}
	
	public function action_send()
	{
		$company = ORM::factory('Catalog_Company')
				->add_custom_select()
				->only_approved()
				->filter_by_promoted()
				->find_by_pk($this->request->param('id'));
		
		if ( ! $company->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		$form = Bform::factory('Frontend_Catalog_Company_Send');
		
		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('company_send');
			
			$email->set_tags(array(
				'%link%'			=> HTML::anchor(catalog::url($company)),
			));
			$email->send($form->email->get_value());
			
			FlashInfo::add(___('catalog.companies.send.success'), 'success');
			$this->redirect_referrer();
		}
		
		$breadcrumbs = $this->_breadcrumb($company);
		$breadcrumbs[$this->template->set_title(___('catalog.companies.send.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/catalog/send')
				->set('form', $form);
	}
	
	public function action_promoted()
	{
		$filters = $this->request->query();
		$filters['promoted_now'] = TRUE;
		$filters['approved'] = TRUE;
		
		$model_company = new Model_Catalog_Company;
		$model_company->apply_filters($filters);
		
		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => $model_company->count_list_companies(),
		));
		
		$companies = $model_company->apply_filters($filters)
			->get_list(NULL, $pager->offset, $pager->items_per_page);
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('catalog.companies.promoted.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/catalog/promoted')
				->set('companies', $companies)
				->set('pager', $pager)
				->set('filters_sorters', $filters);
	}
	
	public function action_show_company()
	{
		$company = ORM::factory('Catalog_Company')
				->with_image()
				->filter_by_promoted()
				->only_approved();
		
		if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled'))
		{
			$company->with_reviews();
		}
		
		$company->find_by_pk($this->request->param('company_id'));
		
		if ( ! $company->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$company->company_visits++;
		$company->save();
		
		$images = $company->get_images();
		
		$form = Bform::factory('Frontend_Catalog_SendMessage');
		
		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_company');
			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
			));
			$email->send($company->company_email, array(
				'reply_to' => $form->email->get_value(),
			));
			
			FlashInfo::add(___('catalog.companies.contact.success'), 'success');
			$this->redirect_referrer();
		}
		
		$category = $company->get_main_category();
		
		$breadcrumbs = $this->_breadcrumb($company);
		breadcrumbs::add($breadcrumbs);
		
		$this->template->set_global('current_category', $category);
		
		$this->template->content = View::factory('frontend/catalog/show_company')
				->set('company', $company)
				->set('images', $images)
				->set('form', $form);
		
		$this->template->set_title($company->company_name);
		$this->template->set_meta_tags(catalog::meta_tags($company));
		
		if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled'))
		{
			$pagination_comments = Pagination::factory(array(
				'total_items' => Model_Catalog_Company_Review::count_comments_by_company($company),
				'items_per_page' => 10,
			));
			
			$comments = Model_Catalog_Company_Review::find_comments_by_company($company, $pagination_comments);
			
			$this->template->content
				->set('pagination_comments', $pagination_comments)
				->set('comments', $comments);
		}
		
		if(Modules::enabled('site_offers'))
		{
			$model_offer = new Model_Offer;
			$model_offer->filter_by_company($company);
			$model_offer->add_active_conditions();
			
			$this->template->content->set('offers', $model_offer->get_list(5));
		}
	}
	
	public function action_category()
	{
		$category = ORM::factory('Catalog_Category')
			->find_by_pk($this->request->param('category_id', 1));
		
		if(!$category->loaded())
			throw new HTTP_Exception_404;
		
		$filters = $this->request->query();
		$filters['category_id'] = $category->pk();
		$filters['approved'] = TRUE;
		
		$model_company = new Model_Catalog_Company;
		$model_company->apply_filters($filters);
		
		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => $model_company->count_list_companies(),
		));
		
		$companies = $model_company
			->with_reviews()
			->apply_filters($filters)
			->get_list(NULL, $pager->offset, $pager->items_per_page);
		
		$breadcrumbs = $this->_breadcrumb($category);
		
		if ( ! empty($filters['province']))
		{
			$breadcrumbs[catalog::province_to_text($filters['province'])] = '';
		}
		
		if(!empty($filters['city']))
		{
			$breadcrumbs[___('catalog.companies.category.from_city', array(':city' => HTML::chars($filters['city'])))] = '';
		}
		breadcrumbs::add($breadcrumbs);
		
		Register::set('current_category', $category);
		$this->template->set_global('current_category', $category);
		$this->template->set_global('allow_query_params', TRUE);
		
		$this->template->content = View::factory('frontend/catalog/show_category')
				->set('companies', $companies)
				->set('pager', $pager)
				->set('category', $category)
				->set('filters_sorters', $filters);
		
		if ( ! $category->is_root())
		{
			$meta_title = $category->category_meta_title;
			if (empty($meta_title))
			{
				$meta_title = $category->category_name;
			}
			$this->template->set_title($meta_title);
			$this->template->add_meta_name('description', $category->category_meta_description);
			$this->template->add_meta_name('keywords', $category->category_meta_keywords);
			$this->template->add_meta_name('robots', $category->category_meta_robots);
			
			//rss links
			$this->template->rss_links[] = array(
				'title' => ___('catalog.rss.category.title', array(':category' => $category->category_name)),
				'uri' => Route::get('rss')->uri(array('controller' => 'catalog', 'action' => 'category', 'id' => $category->pk())),
			);
		}
	}
	
	public function action_add() 
	{
		$types = new Catalog_Company_Promotion_Types();
		$type = $types->get_by_id($this->request->query('type'));
		
		if(!$type OR !$type->is_enabled())
			throw new HTTP_Exception_404('Wrong entry type!');
		
		if($type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
		{
			$payment_module = new Payment_Company_Add();
		}
		else
		{
			$this->logged_only();
			
			$payment_module = new Payment_Company_Promote;
			$payment_module->type($type->get_id());
		}
		
		$form = Bform::factory('Frontend_Catalog_Company_Add', array(
			'payment_module' => $payment_module, 
			'type' => $type,
		));
		
		if ($form->validate())
		{
			$values = $form->get_values();
			$values['user_id'] = $this->_auth->is_logged() ? $this->_current_user->pk() : NULL;
			
			$company = Model_Catalog_Company::factory()->add_company($type, $values, $form->get_files());
			
			if($company->saved())
			{
				if(Modules::enabled('site_newsletter') AND !empty($values['accept_terms']))
				{
					Newsletter::subscribe(Arr::get($values, 'company_email'), !empty($values['accept_ads']));
				}
				
				if($type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC) AND !$payment_module->is_enabled())
				{
					FlashInfo::add(___('catalog.companies.add.success'), 'success');
					$this->redirect(Route::get('site_catalog/home')->uri());
				}
				else
				{
					$payment_module->set_params(array(
						'id' => $company->pk(), 
						'discount' => (bool)Arr::get($values, 'with_discount', FALSE)
					));
					$payment_module->load_object($company);
					$payment_module->pay(Arr::get($values, 'payment_method'));
				}
			}
			else
			{
				FlashInfo::add(___('catalog.companies.add.error'), 'error');
			}
		}
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('catalog.companies.add.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/catalog/add')
				->set('form', $form)
				->set('payment_module', $payment_module);
	}
	public function action_search() 
	{
		$companies = $pager = NULL;
		
		$query = $this->request->query();
		
		$form = Bform::factory('Frontend_Catalog_Company_Search', $query);
		
		if(!empty($query))
		{
			if (empty($query['phrase']) OR $query['phrase'] == ___('catalog.companies.search.phrase.placeholder'))
			{
				FlashInfo::add(___('catalog.companies.search.phrase.error'));
				$this->redirect_referrer();
			}
			
			$model_company = new Model_Catalog_Company();
			$model_company->search_phrase($query['phrase']);
			
			if(!empty($query['category']))
			{
				$model_company->filter_by_category($query['category']);
			}
			
			$model_company->only_approved();
			
			$pager = Pagination::factory(array(
				'items_per_page'   => 20,
				'total_items'	  => $model_company->reset(FALSE)->count_list_companies(),
			));
			
			$companies = $model_company
					->add_custom_select()
					->order_list()
					->limit($pager->items_per_page)
					->offset($pager->offset)
					->find_all($pager);
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('catalog.companies.search.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->set_global('search_params', $query);
		
		$this->template->content = View::factory('frontend/catalog/search')
				->set('form', $form)
				->set('companies', $companies)
				->set('pager', $pager);
	}
	
	public function action_advanced_search()
	{
		$companies = $pager = NULL;
		
		$query = $this->request->query();
		
		$form = Bform::factory('Frontend_Catalog_Company_AdvancedSearch', $query);
		
		if ($form->validate())
		{
			if (empty($query['phrase']) OR $query['phrase'] == ___('catalog.companies.search.phrase.placeholder'))
			{
				FlashInfo::add(___('catalog.companies.search.phrase.error'));
				$this->redirect_referrer();
			}
			
			$model_company = new Model_Catalog_Company();
			$model_company->search_phrase($query['phrase'], $query['where']);
			
			if(!empty($query['category_id']))
			{
				$model_company->filter_by_category($query['category_id']);
			}
			
			if(!empty($query['province_select']))
			{
				$model_company->filter_by_province($query['province_select']);
			}
			
			if(!empty($query['company_county']))
			{
				$model_company->filter_by_county($query['company_county']);
			}
			
			if(!empty($query['city']))
			{
				$model_company->filter_by_city($query['city']);
			}
			
			$model_company->only_approved();
			
			$pager = Pagination::factory(array(
				'items_per_page'   => 20,
				'total_items'	  => $model_company->reset(FALSE)->count_list_companies()
			));
			
			$companies = $model_company
					->add_custom_select()
					->order_list()
					->limit($pager->items_per_page)
					->offset($pager->offset)
					->find_all();
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('catalog.companies.advanced_search.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/catalog/advanced_search')
				->set('form', $form)
				->set('companies', $companies)
				->set('pager', $pager);
	}
	
}
