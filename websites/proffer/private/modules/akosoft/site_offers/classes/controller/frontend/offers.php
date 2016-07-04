<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Offers extends Controller_Offers {

	public function action_age_confirm()
	{
		$document = ORM::factory('Document')
				->where('document_alias', '=', 'age_confirm')
				->find();

		if ($_POST)
		{
			if ( ! empty($_POST['y']))
			{
				if ( ! empty($_POST['remember']))
				{
					cookie::set('age_confirm', TRUE);
				}
				$this->redirect($this->_session->get('age_redirect_url') . '?age_confirmed=1');
			}
			if ( ! empty($_POST['n']))
			{
				$this->redirect('/');
			}
		}

		$this->template->content = View::factory('partials/age_confirm')
				->set('document', $document);
	}

	public function action_report()
	{
		$offer = ORM::factory('Offer')->get_by_id($this->request->param('id'));

		if ( ! $offer->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Frontend_Report', array(
			'current_user' => $this->_current_user,
		));

		if($form->validate())
		{
			$values = $form->get_values();
			
			$email_view = View_Email::factory('report')
				->set('user', $this->_current_user)
				->set('reason', Arr::get($values, 'reason'))
				->set('email', Arr::get($values, 'email'))
				->set('report_name', $offer->offer_title)
				->set('report_anchor', HTML::anchor(URL::site(offers::uri($offer), 'http')));

			$email_view->subject(___('offers.email.report.subject') . ' ' . URL::site('/', 'http'));
			
			Email::send_master($email_view);

			FlashInfo::add(___('offers.report.success'), 'success');

			$url = Route::url('site_offers/frontend/offers/show', array('offer_id' => $offer->pk(), 'title' => URL::title($offer->offer_title)), 'http');
			$this->redirect($url);
		}

		$breadcrumbs = $this->_breadcrumb($offer);
		$breadcrumbs[$this->template->set_title(___('offers.report.title'))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/report')
				->set('form', $form);
	}

	public function action_category()
	{
		$category = new Model_Offer_Category;
		$category->find_by_pk($this->request->param('category_id'));

		if ( ! $category->loaded())
			throw new HTTP_Exception_404();

		$parents = $category->get_parents(FALSE, TRUE);
		$age_confirm = FALSE;
		foreach ($parents as $p)
		{
			if ($p->category_age_confirm)
			{
				$age_confirm = TRUE;
				break;
			}
		}

		if ($age_confirm AND (cookie::get('age_confirm', NULL) === NULL AND Arr::get($_GET, 'age_confirmed', NULL) === NULL) )
		{
			$this->_session->set('age_redirect_url', $this->request->url('http'));
			$this->redirect(Route::url('site_offers/frontend/offers/age_confirm', NULL, 'http'));
		}

		$filters = $this->request->query();
		$filters['category_id'] = $category->category_id;

		$model_offers = new Model_Offer;
		$model_offers->prepare_list_query($filters, FALSE);

		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $model_offers->count_all(),
		));

		$offers = $model_offers->get_list($pager, $filters, array(
			Arr::get($filters, 'sort_by', 'date_added') => Arr::get($filters, 'sort_direction', 'desc'),
		));

		$breadcrumbs = $this->_breadcrumb($category);
		breadcrumbs::add($breadcrumbs);

		Register::set('current_category', $category);
		$this->template->set_global('current_category', $category->pk());
		
		$this->template->content = View::factory('frontend/offers/category')
				->set('offers', $offers)
				->set('pager', $pager)
				->set('category', $category)
				->set('age_confirm', $age_confirm)
				->set('filters_sorters', $filters);

		$this->template->add_meta_name('description', $category->category_meta_description);
		$this->template->add_meta_name('keywords', $category->category_meta_keywords);
		$this->template->add_meta_name('robots', $category->category_meta_robots);
		$this->template->add_meta_name('revisit-after', $category->category_meta_revisit_after);
		$this->template->set_title($category->category_meta_title);

		//rss links
		$this->template->rss_links[] = array(
			'title' => ___('offers.rss.category.title', array(':category' => $category->category_name)),
			'uri' => Route::get('rss')->uri(array('controller' => 'offers', 'action' => 'category', 'id' => $category->pk())),
		);
	}

	public function action_show()
	{
		$offer = ORM::factory('Offer')->get_by_id($this->request->param('offer_id', 0), Arr::get($this->request->query(), 'preview', FALSE));

		if (!$offer->loaded())
			throw new HTTP_Exception_404();

		$categories = ORM::factory('Offer_Category')
				->join('offers_to_categories', 'RIGHT')->on('offer_category.category_id', '=', 'offers_to_categories.category_id')
				->order_by('offers_to_categories.category_id', 'DESC')
				->where('offers_to_categories.offer_id', '=', $offer->pk())
				->find_all();

		$age_confirm = FALSE;
		foreach ($categories as $p)
		{
			if ($p->category_age_confirm AND ! cookie::get('age_confirm'))
			{
				$age_confirm = TRUE;
				break;
			}
		}

		if ($age_confirm AND (cookie::get('age_confirm', NULL) === NULL AND Arr::get($_GET, 'age_confirmed', NULL) === NULL) )
		{
			$this->_session->set('age_redirect_url', $this->request->url('http'));
			$this->redirect(Route::url('site_offers/frontend/offers/age_confirm', NULL, 'http'));
		}

		$offer->inc_visits();

		$category = $offer->get_last_category();

		$breadcrumbs = $this->_breadcrumb($offer);
		breadcrumbs::add($breadcrumbs);

		Register::set('current_category', $category);
		$this->template->set_global('current_category', $category->pk());
		
		$this->template->content = View::factory('frontend/offers/show')
				->set('offer', $offer);

		$this->template->set_title($offer->offer_title);
		$this->template->set_meta_tags(offers::meta_tags($offer));
	}

	public function action_send()
	{
		$offer = ORM::factory('Offer')->get_by_id($this->request->param('id'));

		if ( ! $offer->pk())
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Frontend_Offer_Send');

		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('offer_send_to_friend');

			$url = Route::url('site_offers/frontend/offers/show', array(
				'offer_id' => $offer->pk(), 
				'title' => URL::title($offer->offer_title)
			), 'http');

			$email->set_tags(array(
				'%link%'		=> HTML::anchor($url),
			));
			$email->send($form->email->get_value());
			
			FlashInfo::add(___('offers.send.success'), 'success');
			$this->redirect(offers::uri($offer));
		}

		$breadcrumbs = $this->_breadcrumb($offer);
		$breadcrumbs[$this->template->set_title(___('offers.send.title'))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/send')
				->set('form', $form);
	}

	public function action_advanced_search()
	{
		$offers = $pager = NULL;

		$query = $this->request->query();

		$form = Bform::factory('Frontend_Offer_AdvancedSearch', $query);

		if ($form->validate())
		{
			$model_offer = new Model_Offer();
			$model_offer->search_phrase($query['phrase'], $query['where']);

			if(!empty($query['category']))
			{
				$category = new Model_Offer_Category((int)$query['category']);

				if($category->loaded())
				{
					$categories = $category->get_descendants(TRUE);

					if(count($categories))
					{
						$model_offer->filter_by_category($categories->as_array('category_id'));
					}
				}
			}

			if(!empty($query['province_select']))
			{
				$model_offer->filter_by_province($query['province_select']);
			}

			if(!empty($query['offer_county']))
			{
				$model_offer->filter_by_county($query['offer_county']);
			}

			if(!empty($query['city']))
			{
				$model_offer->filter_by_city($query['city']);
			}

			$model_offer->add_active_conditions()
				->filter_by_prices(Arr::get($query, 'price_from'), Arr::get($query, 'price_to'));

			$pager = Pagination::factory(array(
				'items_per_page'   => 20,
				'total_items'	  => $model_offer->reset(FALSE)->count_all()
			));

			$offers = $model_offer->get_list($pager);

			if (count($offers) == 0)
			{
				FlashInfo::add(___('offers.advanced_search.no_results'), 'error');
			}
		}

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('offers.advanced_search.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/advanced_search')
				->set('form', $form)
				->set('offers', $offers)
				->set('pager', $pager);
	}

	public function action_search()
	{
		$query = $this->request->query();

		$offers = $pager = NULL;

		if(!empty($query))
		{
			if (empty($query['phrase']) OR $query['phrase'] == ___('offers.search.phrase.placeholder'))
			{
				FlashInfo::add(___('offers.search.phrase.error'));
				$this->redirect_referrer();
			}

			$model_offer = new Model_Offer();
			$model_offer->search_phrase($query['phrase']);

			if(!empty($query['category']))
			{
				$category = new Model_Offer_Category((int)$query['category']);

				if($category->loaded())
				{
					$categories = $category->get_descendants(TRUE);

					if(count($categories))
					{
						$model_offer->filter_by_category($categories->as_array('category_id'));
					}
				}
			}

			$model_offer->add_active_conditions();

			$pager = Pagination::factory(array(
				'items_per_page'   => 20,
				'total_items'	  => $model_offer->reset(FALSE)->count_all()
			));

			$offers = $model_offer->get_list($pager);;
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[___('offers.search.results')] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->set_title(___('offers.search.title'));
		
		$this->template->search_params = $query;
		$this->template->content = View::factory('frontend/offers/search')
				->set('offers', $offers)
				->set('pager', $pager);
	}

	public function action_promote()
	{
		$offer = ORM::factory('Offer', $this->request->param('offer_id'));

		if ( ! $offer->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$has_premium_plus_company = FALSE;

		if(Modules::enabled('site_catalog') && $offer->has_company())
		{
			$has_premium_plus_company = $offer->catalog_company->is_promoted(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS);
		}
		
		$this->template->content = View::factory('frontend/offers/promote')
			->set('offer', $offer)
			->set('user', $this->_auth->get_user())
			->set('has_premium_plus_company', $has_premium_plus_company);
		
		//payment add
		
		$payment_add = $this->request->query('from') == 'add' ? 
			payment::load_payment_module('offer_add') : NULL;
		
		if($payment_add)
		{
			$payment_add->object_id($offer->pk());
			$payment_add->set_params(array(
				'id' => $offer->pk(),
			));
			$payment_add->load_object();
			
			if($payment_add->is_enabled())
			{
				$form_add = Bform::factory('Frontend_Offer_Payment_Add', array('payment_module' => $payment_add));

				if($form_add->validate())
				{
					$payment_method = $form_add->payment_method->get_value();

					$payment_add->pay($payment_method);
				}

				$this->template->content->set('payment_add', $payment_add)
					->set('form_add', $form_add);
			}
		}
		
		//payment promote
		
		$payment_promote = new Payment_Offer_Promote();
		$payment_promote->set_params(array(
			'id' => $offer->pk(),
			'distinction' => Model_Offer::DISTINCTION_PREMIUM_PLUS,
		));
		$payment_promote->load_object($offer);
		
		if($payment_promote->is_enabled('premium_plus'))
		{
			$form_promote = Bform::factory('Frontend_Offer_Payment_Promote', array(
				'payment_module' => $payment_promote, 
				'type' => 'premium_plus',
				'has_premium_plus_company' => $has_premium_plus_company,
			));

			if($form_promote->validate())
			{
				$payment_method = $form_promote->payment_method->get_value();

				if($payment_method == 'company_premium_plus' && $has_premium_plus_company)
				{
					$payment_promote->pay(NULL, TRUE);
				}
				elseif($payment_method == 'offer_points' && $this->_auth->is_logged())
				{
					//TODO przenieść jako provider płatności

					$user = $this->_auth->get_user();

					if (!$user->data->offer_points)
					{
						throw new HTTP_Exception_404;
					}

					$user->data->offer_points = $user->data->offer_points - 1;
					$user->data->save();

					$payment_promote->pay(NULL, TRUE);
				}
				elseif($payment_method)
				{
					$payment_promote->pay($payment_method);
				}
				else
				{
					FlashInfo::add(___('payments.forms.payment_method.error'), 'error');
				}
			}

			$this->template->content->set('payment_promote', $payment_promote)
				->set('form_promote', $form_promote);
		}

		$breadcrumbs = $this->_breadcrumb($offer);
		$breadcrumbs[$this->template->set_title(___('offers.promote.title'))] = '';

		breadcrumbs::add($breadcrumbs);
	}

	public function action_pre_add()
	{
		$document = Pages::get('offer_pre_add');
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('offers.add.title'))] = '';

		$this->template->content = View::factory('frontend/offers/pre_add')
				->set('document', $document);
	}

	public function action_add()
	{
		$has_promoted_companies = FALSE;

		if($this->_auth->is_logged() && Modules::enabled('site_catalog'))
		{
			$company = new Model_Catalog_Company;
			$company->filter_by_user($this->_current_user);
			$company->filter_by_promoted();

			$has_promoted_companies = $company->count_all();
		}

		$form_params['auth'] = $this->_auth;
		$form_params['session'] = $this->_session;
		$form_params['has_promoted_companies'] = $has_promoted_companies;

		$form = Bform::factory('Frontend_Offer_Add', $form_params);

		if ($form->validate())
		{
			$payment_add = new Payment_Offer_Add;
			
			$values = $form->get_values();
			$values['user_id'] = $this->_session->get('user_id', 0);
			$values['offer_is_approved'] = ($this->_auth->is_logged() OR ! Kohana::$config->load('modules.site_offers.settings.confirm_required'));
			
			if($payment_add->is_enabled())
			{
				if($has_promoted_companies AND isset($values['company_id']))
				{
					$company = new Model_Catalog_Company;
					$company->filter_by_user($this->_current_user);
					$company->find_by_pk($values['company_id']);
					
					$values['offer_is_paid'] = ($company->loaded() AND $company->is_promoted(Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS));
				}
				else
				{
					$values['offer_is_paid'] = FALSE;
				}
			}
			else
			{
				$values['offer_is_paid'] = TRUE;
			}
			
			$offer = ORM::factory('Offer')->add_offer($values, $form->get_files());
			
			if($offer->is_paid())
			{
				if($offer->offer_is_approved)
				{
					FlashInfo::add(___('offers.add.success'), 'success');
				}
				else
				{
					FlashInfo::add(___('offers.add.success', 'moderate'), 'success');
				}
			}
			else
			{
				FlashInfo::add(___('offers.add.success', 'payment'), 'success');
			}
			
			if(!$offer->offer_is_approved AND Kohana::$config->load('modules.site_offers.settings.confirmation_email'))
			{
				$offer->send_offer_approve();
			}
			
			if(Modules::enabled('site_newsletter') AND !empty($values['accept_terms']))
			{
				Newsletter::subscribe(Arr::get($values, 'offer_email'), !empty($values['accept_ads']));
			}
			
			$this->redirect(Route::url('site_offers/frontend/offers/promote', array(
				'offer_id' => $offer->pk()
			), 'http') . '?from=add&hash=' . $offer->offer_hash);
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('offers.add.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/add')
			->set('form', $form)
			->set('has_promoted_companies',  $has_promoted_companies);
	}

	public function action_show_by_user()
	{
		$user = ORM::factory('User', $this->request->param('id'));

		if ( ! $user->user_id)
		{
			throw new HTTP_Exception_404();
		}

		$filters = offers::filters('show_by_user_filters', $this->_session, $user);
		$filters['user_id'] = $user->user_id;

		$pager = Pagination::factory(array(
			'items_per_page'   => $filters['on_page'],
			'total_items'	  => ORM::factory('Offer')->count_all_list($filters)
		));

		$offers = ORM::factory('Offer')->get_all($pager->offset, $pager->items_per_page, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('offers.show_by_user.title', array(
			':user_name' => $user->user_name,
		)))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/show_by_user')
			->set('user', $user)
			->set('offers', $offers)
			->set('pager', $pager);
	}

	public function action_show_by_company()
	{
		if(!Modules::enabled('site_catalog'))
			throw new HTTP_Exception_404;
		
		$company = new Model_Catalog_Company;
		$company->find_by_pk($this->request->param('company_id'));

		if (!$company->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		$filters = $this->request->query();
		$filters['company'] = $company;
		
		$model_offers = new Model_Offer;
		$model_offers->prepare_list_query($filters, FALSE);

		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $model_offers->count_all(),
		));

		$offers = $model_offers->get_list($pager, $filters, array(
			Arr::get($filters, 'sort_by', 'date_added') => Arr::get($filters, 'sort_direction', 'desc'),
		));

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('offers.show_by_company.title', array(':company_name' => $company->company_name)))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/show_by_company')
				->set('offers', $offers)
				->set('filters_sorters', $filters)
				->set('pager', $pager)
				->set('company', $company);
	}

	public function action_home()
	{
		$from = $this->request->query('from');

		$breadcrumbs = $this->_breadcrumb();
		breadcrumbs::add($breadcrumbs);

		$offers = new Model_Offer;
		$offers->custom_select();
		
		$limit = Kohana::$config->load('modules.site_offers.settings.index_box_limit');
		if(!$limit)
		{
			$limit = 10;
		}

		if($from == 'recommended')
		{
			$offers = $offers->get_recommended($limit);
		}
		else
		{
			$offers = $offers
				->apply_sorting(array('date_added' => 'desc'), FALSE)
				->get_promoted($limit);
		}

		$this->template->content = View::factory('frontend/offers/home')
				->set('offers', $offers)
				->set('from', $from);
	}

	public function action_index()
	{
		$filters = $this->request->query();
		$filters['category_id'] = NULL;

		$model_offers = new Model_Offer;
		$model_offers->prepare_list_query($filters, FALSE);

		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> $model_offers->count_all(),
		));

		$offers = $model_offers->get_list($pager, $filters, array(
			Arr::get($filters, 'sort_by', 'date_added') => Arr::get($filters, 'sort_direction', 'desc'),
		));

		$breadcrumbs = $this->_breadcrumb();
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/index')
				->set('offers', $offers)
				->set('filters_sorters', $filters)
				->set('pager', $pager);
	}

	public function action_send_coupon()
	{
		$offer = new Model_Offer();
		$offer->add_image_to_list();
		$offer->get_by_id((int)$this->request->param('id'));

		if(!$offer->loaded() || !$offer->is_active())
			throw new HTTP_Exception_404;

		$form = Bform::factory('Frontend_Offer_SendCoupon', array('offer' => $offer));

		if($form->validate())
		{
			$values = $form->get_values();
			$values['amount'] = Arr::get($values, 'amount', 1);
			
			$coupon_owner =  new Model_Coupon_Owner();
			$user_limit = $coupon_owner->get_user_limit($offer, $values['email']);
			
			if($user_limit AND $values['amount'] <= $offer->get_limit())
			{
				$coupons = array();
				
				for($i=0; $i<$values['amount']; $i++)
				{
					$coupon_owner =  new Model_Coupon_Owner();
					$coupon_owner->add_owner($offer, $values['email']);
					$coupons[] = $coupon_owner;
				}
				
				if($coupons)
				{
					$offer->send_coupons($coupons);

					FlashInfo::add(___('offers.send_coupon.success', (int)$values['amount']), 'success');
				}
			}
			else
			{
				FlashInfo::add(___('offers.send_coupon.error.user_limit'), 'error');
			}

			$this->redirect(Route::get('site_offers/frontend/offers/show')->uri(array(
					'offer_id' => $offer->pk(),
					'title' => URL::title($offer->offer_title),
				)));
		}

		$breadcrumbs = $this->_breadcrumb($offer);
		$breadcrumbs[___('offers.send_coupon.title')] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/coupons/send')
			->set('form', $form)
			->set('offer', $offer)
			->render();
	}
	
	public function action_contact()
	{
		$offer = new Model_Offer();
		$offer->get_by_id((int)$this->request->param('id'));
		
		if(!$offer->loaded())
		{
			throw new HTTP_Exception_404('Offer not found! (:id)', array(
				':id' => $this->request->param('id'),
			));
		}
		
		$form = Bform::factory('Frontend_Offer_Contact', array(
			'offer' => $offer,
		));

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('offers.contact');
			
			$email->set_tags(array(
				'%email.subject%'	=> HTML::chars($form->subject->get_value()),
				'%email.message%'	=> HTML::chars($form->message->get_value()),
				'%email.from%'		=> HTML::chars($form->email->get_value()),
				'%offer.title%'		=> HTML::chars($offer->offer_title),
				'%offer.link%'		=> HTML::anchor(URL::site(offers::uri($offer, 'http'), 'http')),
			));
			$offer->send_email_message($email, NULL, array('reply_to' => $form->email->get_value()));
			
			FlashInfo::add(___('offers.contact.success'), 'success');
			$this->redirect(offers::uri($offer));
		}

		$breadcrumbs = $this->_breadcrumb($offer);
		$breadcrumbs[$this->template->set_title(___('offers.contact.title'))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/offers/contact')
			->set('form', $form)
			->set('offer', $offer)
			->render();
		
	}
	
}
