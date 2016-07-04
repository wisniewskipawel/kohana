<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Products extends Controller_Products {

	public function action_home()
	{
		breadcrumbs::add($this->_breadcrumb());

		$product = new Model_Product;
		
		$limit = Kohana::$config->load('modules.site_products.home_box_products');
		
		$this->template->layout_data['frontend_main_index_top'] = FALSE;
		$this->template->content = View::factory('frontend/products/home')
			->set('promoted_products', $product->get_promoted($limit ? $limit : 4));
	}
	
	public function action_pre_add()
	{
		$document = Pages::get('product_pre_add');

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.add.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/pre_add')
				->set('document', $document);
	}

	public function action_report()
	{
		$product = ORM::factory('product', $this->request->param('id'));

		if ( ! $product->loaded())
		{
			throw new HTTP_Exception_404(404);
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
				->set('report_name', $product->product_title)
				->set('report_anchor', HTML::anchor(Products::uri($product, 'http')));

			$email_view->subject(___('products.email.report.subject'));
			
			Email::send_master($email_view);

			FlashInfo::add(___('products.report.success'), 'success');

			$this->redirect(products::uri($product));
		}
		
		$breadcrumbs = $this->_breadcrumb($product);
		$breadcrumbs[$this->template->set_title(___('products.report.title'))] = '/';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/report')
				->set('form', $form);
	}

	public function action_category()
	{
		$category = ORM::factory('product_Category', $this->request->param('category_id'));

		if ( ! $category->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		$filters = $this->request->query();
		$filters['category_id'] = $category->category_id;

		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb($category);
		breadcrumbs::add($breadcrumbs);

		$this->template->set_global('current_category', $category);

		$this->template->content = View::factory('frontend/products/category')
			->set('filters_sorters', $filters)
			->set('products', $products)
			->set('pager', $pager)
			->set('category', $category);

		$this->template->set_title($category->category_meta_title ? 
			$category->category_meta_title : ___('products.category.title', array(':category' => $category->category_name))
		);
		$this->template->add_meta_name('description', $category->category_meta_description);
		$this->template->add_meta_name('keywords', $category->category_meta_keywords);
		$this->template->add_meta_name('robots', $category->category_meta_robots);

		//rss links
		$this->template->rss_links[] = array(
			'title' => ___('products.rss.category.title', array(':category' => $category->category_name)),
			'uri' => Route::get('rss')->uri(array('controller' => 'products', 'action' => 'category', 'id' => $category->pk())),
		);
	}

	public function action_show()
	{
		$product = ORM::factory('product')
			->get_by_id($this->request->param('product_id', 0), !!$this->request->query('preview'));

		if (!$product->loaded()) 
		{
			throw new HTTP_Exception_404();
		}

		$product->inc_visits();

		$images = $product->get_images();

		$category = $product->categories
				->order_by('product_category.category_level', 'DESC')
				->find();
		
		$form = Bform::factory('Frontend_Product_SendMessage');

		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_product');

			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
				'%product.title%'	=> $product->product_title,
				'%product.link%'	=> HTML::anchor(
					products::uri($product, 'http'),
					$product->product_title
				),
			));
			$product->send_email_message($email, NULL, array('reply_to' => $form->email->get_value()));
			
			FlashInfo::add(___('products.contact.success'), 'success');
			$this->redirect_referrer();
		}
		
		$breadcrumbs = $this->_breadcrumb($product);
		breadcrumbs::add($breadcrumbs);

		$this->template->set_global('current_category', $category);

		$this->template->content = View::factory('frontend/products/show')
				->set('product', $product)
				->set('images', $images)
				->set('form', $form)
				->set('similar_products', ORM::factory('Product')->find_similar($product, 5));

		$this->template->set_title($product->product_title);
		$this->template->meta_description = Text::limit_chars(strip_tags($product->product_content), 160, '...', TRUE);
		$this->template->set_meta_tags(Products::meta_tags($product));
		
		$tags = new Model_Product_Tag;
		$tags->filter_by_product($product);
		$this->template->meta_keywords = $tags->as_string();
	}

	public function action_send()
	{
		$product = ORM::factory('product')->get_by_id($this->request->param('id'));

		if (!$product->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Frontend_product_Send');

		if ($form->validate())
		{
			$email = Model_Email::email_by_alias('product_send_to_friend');

			$url = products::uri($product, 'http');

			$email->set_tags(array(
				'%link%'		=> '<a href="' .$url .'">'. $url .'</a>'
			));
			$email->send($form->email->get_value());
			FlashInfo::add(___('products.send.success'), 'success');
			
			$this->redirect(products::uri($product));
		}
		
		$breadcrumbs = $this->_breadcrumb($product);
		$breadcrumbs[$this->template->set_title(___('products.send.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/send')
				->set('form', $form);
	}

	public function action_advanced_search()
	{
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.advanced_search.title'))] = URL::site($this->request->uri());

		$products = $pager = NULL;

		$query = $this->request->query();

		$form = Bform::factory('Frontend_product_AdvancedSearch', $query);

		if ($form->validate())
		{
			$model_product = new Model_product();
			$model_product->search_phrase($query['phrase'], $query['where']);

			if(!empty($query['category_id']))
			{
				$category = new Model_product_Category((int)$query['category_id']);

				if($category->loaded())
				{
					$categories = $category->get_descendants(TRUE);

					if(count($categories))
					{
						$model_product->filter_by_category($categories->as_array('category_id'));
					}
				}
			}

			if(!empty($query['product_province']))
			{
				$model_product->filter_by_province($query['product_province']);
			}

			if(!empty($query['product_county']))
			{
				$model_product->filter_by_county($query['product_county']);
			}

			if(!empty($query['city']))
			{
				$model_product->filter_by_city($query['city']);
			}

			if(!empty($query['product_manufacturer']))
			{
				$model_product->filter_by_manufacturer($query['product_manufacturer']);
			}

			if(!empty($query['product_type']))
			{
				$model_product->filter_by_type($query['product_type']);
			}

			$model_product->add_active_conditions()
				->filter_by_prices(Arr::get($query, 'price_from'), Arr::get($query, 'price_to'));

			$pager = Pagination::factory(array(
				'items_per_page'	=> 20,
				'total_items'		=> $model_product->reset(FALSE)->count_all()
			));

			$products = $model_product->get_list($pager);

			if (count($products) == 0)
			{
				FlashInfo::add(___('products.search.no_results'), 'error');
			}
			else
			{
				$breadcrumbs[___('products.search.results')] = '';
			}
		}

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/advanced_search')
				->set('form', $form)
				->set('products', $products)
				->set('pager', $pager);
	}

	public function action_search()
	{
		$query = $this->request->query();

		$products = $pager = NULL;

		if(!empty($query))
		{
			if (empty($query['phrase']) OR $query['phrase'] == ___('products.search.phrase.placeholder'))
			{
				FlashInfo::add(___('products.search.phrase.error'));
				$this->redirect_referrer();
			}

			$model_product = new Model_product();
			$model_product->search_phrase($query['phrase']);

			if(!empty($query['category']))
			{
				$category = new Model_product_Category((int)$query['category']);

				if($category->loaded())
				{
					$categories = $category->get_descendants(TRUE);

					if(count($categories))
					{
						$model_product->filter_by_category($categories->as_array('category_id'));
					}
				}
			}

			$model_product->add_active_conditions();

			$pager = Pagination::factory(array(
				'items_per_page'   => 20,
				'total_items'	  => $model_product->reset(FALSE)->count_all()
			));

			$products = $model_product->get_list($pager);;
		}
		
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[___('products.search.results')] = '';
		
		breadcrumbs::add($breadcrumbs);

		$this->template->search_params = $query;
		$this->template->content = View::factory('frontend/products/search')
				->set('products', $products)
				->set('pager', $pager);
		
		$this->template->set_title(___('products.search.title'));
	}

	public function action_promoted()
	{
		$filters = $this->request->query();
		$filters['promoted'] = TRUE;

		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.promoted.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/promoted')
				->set('filters_sorters', $filters)
				->set('products', $products)
				->set('pager', $pager);
	}

	public function action_promote()
	{
		$product = ORM::factory('Product', $this->request->param('product_id'));

		if ( ! $product->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$payment_add = $this->request->query('from') == 'add' ? 
			payment::load_payment_module('product_add') : NULL;
		
		if($payment_add)
		{
			$payment_add->object_id($product->pk());
			$payment_add->set_params(array(
				'id' => $product->pk(),
			));
			$payment_add->load_object();
		}
		
		$payment_module = payment::load_payment_module('product_promote');
		
		if ($this->request->method() == HTTP_Request::POST)
		{
			$payment_method = $this->request->post('payment_method');
			
			$params = array(
				'id' => $product->pk(),
				'distinction' => $this->request->post('product_distinction')
			);
			$payment_module->set_params($params);
			$payment_module->load_object($product);
			
			if($payment_method == 'company')
			{
				if(Model_Product::check_promotion_limit($product))
				{
					$payment_module->pay(NULL, TRUE);
				}
				else
				{
					FlashInfo::add(___('products.promote.company_free.error'), 'error');
				}
			}
			else
			{
				if($this->request->post('product_distinction'))
				{
					if($payment_method)
					{
						$payment_module->pay($payment_method);
					}
					else
					{
						FlashInfo::add(___('payments.forms.payment_method.error'), 'error');
					}
				}
				else
				{
					if($payment_add AND $payment_add->is_enabled())
					{
						$payment_add->pay($payment_method);
					}
				}
			}
		}
		
		$breadcrumbs = $this->_breadcrumb($product);
		$breadcrumbs[$this->template->set_title(___('products.promote.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/promote')
				->set('product', $product)
				->set('user', $this->_auth->get_user())
				->set('payment_module', $payment_module)
				->set('payment_add', $payment_add);
	}

	public function action_add()
	{
		$form_params['auth'] = $this->_auth;
		$form_params['session'] = $this->_session;

		$form = Bform::factory('Frontend_Product_Add', $form_params);

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['user_id'] = $this->_current_user ? $this->_current_user->pk() : NULL;
			
			$payment_module = Payment::load_payment_module('product_add');

			if($payment_module->is_enabled())
			{
				$values['product_is_approved'] = 0;
				FlashInfo::add(___('products.add.success.payment'), 'success');
			}
			else
			{
				if ($this->_auth->is_logged() OR ! Kohana::$config->load('modules.site_products.confirm_required'))
				{
					$values['product_is_approved'] = 1;
					FlashInfo::add(___('products.add.success.default'), 'success');
				}
				else
				{
					$values['product_is_approved'] = 0;
					FlashInfo::add(___('products.add.success.moderate'), 'success');
				}
			}
			
			$product = (new Model_Product())
				->add_product($values);
			
			if(Modules::enabled('site_newsletter') AND !empty($values['accept_terms']))
			{
				Newsletter::subscribe(Arr::get($values, 'product_email'), !empty($values['accept_ads']));
			}
			
			$this->redirect(Route::get('site_products/frontend/products/promote')->uri(array(
				'product_id' => $product->pk(),
			)).'?from=add');
		}

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.add.title'))] = '';
		
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/add')
				->set('form', $form);
	}

	public function action_show_by_user()
	{
		$user = ORM::factory('User', $this->request->param('id'));

		if ( ! $user->user_id)
		{
			throw new HTTP_Exception_404(404);
		}

		$filters = $this->request->query();
		$filters['user_id'] = $user->user_id;

		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.show_by_user.title', array(':user' => $user->user_name)))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/show_by_user')
			->set('user', $user)
			->set('products', $products)
			->set('filters_sorters', $filters)
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

		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.show_by_company.title', array(':company_name' => $company->company_name)))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/show_by_company')
				->set('products', $products)
				->set('filters_sorters', $filters)
				->set('pager', $pager)
				->set('company', $company);
	}

	public function action_index()
	{
		$filters = $this->request->query();

		$pager = Pagination::factory(array(
			'items_per_page'   => Arr::get($filters, 'on_page', 20),
			'total_items'	  => ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.index.title'))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('frontend/products/index')
				->set('filters_sorters', $filters)
				->set('products', $products)
				->set('pager', $pager);
	}
	
	public function action_order() 
	{
		$product = new Model_Product;
		$product->add_active_conditions();
		$product->find_by_pk($this->request->param('id'));
		
		if(!$product->loaded() OR !$product->product_buy)
		{
			throw new HTTP_Exception_404;
		}
		
		if(!$product->product_state)
		{
			FlashInfo::add(___('products.order.error.product_state'), FlashInfo::ERROR);
			$this->redirect(Products::uri($product));
		}
		
		$form = Bform::factory('Frontend_Product_Order', array('product' => $product));
		
		if($form->validate())
		{
			$values = $form->get_values();
			$tags = array();
			
			foreach($values as $name => $val)
			{
				$tags['%'.$name.'%'] = $val;
			}
			
			if($tags['%person_type%'] == 'company')
			{
				$tags['%person_type%'] = ___('products.person_types.company');
				$tags['%name%'] = ___('products.email.order.company_name', array(
					':company_name' => Arr::get($tags, '%company_name%'),
					':nip' => $tags['%company_nip%'],
				));
			}
			else
			{
				$tags['%person_type%'] = ___('products.person_types.person');
			}
			
			$tags['%remarks%'] = Text::auto_p($tags['%remarks%']);
			
			$tags['%product.title%'] = $product->product_title;
			$tags['%product.link%'] = HTML::anchor(Products::uri($product, 'http'), $product->product_title);
			
			$email_seller = Model_Email::email_by_alias('product_order_seller');
			$email_seller->set_tags($tags);
			$product->send_email_message($email_seller);
			
			$email_buyer = Model_Email::email_by_alias('product_order_buyer');
			$email_buyer->set_tags($tags);
			$email_buyer->send($values['email']);
			
			FlashInfo::add(___('products.order.success'));
			$this->redirect(Products::uri($product));
		}
		
		$breadcrumbs = $this->_breadcrumb($product);
		$breadcrumbs[$this->template->set_title(___('products.order.title'))] = '';
		breadcrumbs::add($breadcrumbs);
		
		$this->template->content = View::factory('frontend/products/order')
			->set('product', $product)
			->set('form', $form);
	}

	public function action_tag()
	{
		$tag = new Model_Product_Tag();
		$tag->find_by_raw_tag($this->request->param('tag'));
		
		if(!$tag->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$filters = $this->request->query();
		$filters['tag'] = $tag;

		$pager = Pagination::factory(array(
			'items_per_page'	=> Arr::get($filters, 'on_page', 20),
			'total_items'		=> ORM::factory('product')->count_all_list($filters)
		));

		$products = ORM::factory('product')->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('products.tag.title', array(':tag' => HTML::chars($tag->tag))))] = '';

		breadcrumbs::add($breadcrumbs);
		
		if(count($products))
		{
			$tag->counter++;
			$tag->save();
		}

		$this->template->content = View::factory('frontend/products/tag')
				->set('products', $products)
				->set('filters_sorters', $filters)
				->set('pager', $pager)
				->set('tag', $tag);
	}
	
	public function _breadcrumb($model = NULL)
	{
		$breadcrumbs = array(
			'products.title'	=> Route::url('site_products/frontend/products/index'),
		);
		
		if($model instanceof Model_product)
		{
			if(in_array(Route::name($this->request->route()), array(
				'site_products/frontend/products/search',
				'site_products/frontend/products/advanced_search',
			))) 
			{
				$breadcrumbs['products.search.results'] = $this->request->referrer();
			} 
			else 
			{
				if($model->has_category())
				{
					list($breadcrumbs_cats, $categories_ids) = products::breadcrumbs($model->get_last_category());
					$breadcrumbs = Arr::merge($breadcrumbs, $breadcrumbs_cats);
				}
			}
			
			$breadcrumbs[$model->product_title] = products::uri($model, TRUE);
		}
		elseif($model instanceof Model_product_Category)
		{
			list($breadcrumbs_cats, $categories_ids) = products::breadcrumbs($model);
			$breadcrumbs = Arr::merge($breadcrumbs, $breadcrumbs_cats);
		}
		
		return $breadcrumbs;
	}
	
}

