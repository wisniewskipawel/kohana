<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Frontend_Jobs extends Controller_Jobs {

	public function action_home()
	{
		breadcrumbs::add($this->_breadcrumb());
		
		$this->template->layout = 'jobs/layouts/home';
		$this->template->content = View::factory('jobs/frontend/home');
	}

	public function action_add()
	{
		$this->logged_only();
		
		$payment_promote = new Payment_Job_Promote();
		
		$form_params['current_user'] = $this->_current_user;

		$form = Bform::factory('Frontend_Jobs_Add', $form_params);

		if($form->validate())
		{
			$values = $form->get_values();
			$values['user_id'] = $this->_auth->get_user_id();
			
			$payment_add = new Payment_Job_Add;
			$values['is_paid'] = !$payment_add->is_enabled();
			$values['is_approved'] = TRUE;
			
			$job = Model_Job::factory()->add_job($values);
			
			if(!empty($values['promotion']))
			{
				$payment_promote->set_job($job);
				$payment_promote->set_distinction($values['promotion']);
				return $payment_promote->pay();
			}

			if($job->is_paid)
			{
				FlashInfo::add(___('jobs.add.success'), 'success');
				return $this->redirect(Jobs::uri($job).'?preview=1');
			}
			else
			{
				FlashInfo::add(___('jobs.add.success_payment'), 'success');
				
				$payment_add->set_job($job);
				return $payment_add->pay();
			}
		}

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('jobs.add.title'))] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/add')
			->set('form', $form);
	}

	public function action_report()
	{
		$job = Model_Job::factory()->find_by_pk($this->request->param('id'));

		if(!$job->loaded())
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
				->set('report_name', $job->title)
				->set('report_anchor', HTML::anchor(Jobs::url($job, 'http')));

			$email_view->subject(___('jobs.report.email.subject', array(':site' => URL::site('/', 'http'))));

			Email::send_master($email_view);

			FlashInfo::add('jobs.report.success', 'success');

			$this->redirect(Jobs::uri($job));
		}

		$breadcrumbs = $this->_breadcrumb($job);
		$breadcrumbs[$this->template->set_title(___('jobs.report.title'))] = '/';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/report')
			->set('form', $form);
	}

	public function action_index()
	{
		$filters = $this->request->query();

		$model = new Model_Job;

		$pager = Pagination::factory(array(
			'items_per_page' => Arr::get($filters, 'on_page', 20),
			'total_items' => $model->apply_filters($filters)->count_all(),
		));

		$jobs = $model->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/index')
			->set('filters_sorters', $filters)
			->set('jobs', $jobs)
			->set('pager', $pager);
	}

	public function action_category()
	{
		$category = Model_Job_Category::factory()->find_by_pk($this->request->param('category_id'));

		if(!$category->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$filters = $this->request->query();
		$filters['category'] = $category;

		$model = new Model_Job;

		$pager = Pagination::factory(array(
			'items_per_page' => Arr::get($filters, 'on_page', 20),
			'total_items' => $model->apply_filters($filters)->count_all(),
		));

		$jobs = $model->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb($category);
		breadcrumbs::add($breadcrumbs);

		$this->template->set_global('current_category', $category);

		$this->template->content = View::factory('jobs/frontend/category')
			->set('filters_sorters', $filters)
			->set('jobs', $jobs)
			->set('pager', $pager)
			->set('category', $category);

		$this->template->set_title($category->category_meta_title ? 
			$category->category_meta_title : ___('jobs.category.title', array(':category' => $category->category_name))
		);
		$this->template->add_meta_name('description', $category->category_meta_description);
		$this->template->add_meta_name('keywords', $category->category_meta_keywords);
		$this->template->add_meta_name('robots', $category->category_meta_robots);
		$this->template->add_meta_name('revisit-after', $category->category_meta_revisit_after);

		//rss links
		$this->template->rss_links[] = array(
			'title' => ___('jobs.rss.category.title', array(':category' => $category->category_name)),
			'uri' => Route::get('rss')->uri(array('controller' => 'jobs', 'action' => 'category', 'id' => $category->pk())),
		);
	}

	public function action_show()
	{
		$job = Model_Job::factory()
			->with_count_replies()
			->get_by_id($this->request->param('id'), !!$this->request->query('preview'), TRUE);

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$job->inc_visits();

		$breadcrumbs = $this->_breadcrumb($job);
		breadcrumbs::add($breadcrumbs);

		$category = $job->get_last_category();
		Register::set('current_category', $category);
		$this->template->set_global('current_category', $category);

		$this->template->layout = 'jobs/layouts/show';
		$this->template->content = View::factory('jobs/frontend/show')
			->set('job', $job);

		$this->template->set_title($job->title);
		$this->template->set_meta_tags(Jobs::meta_tags($job));
	}
	
	public function action_contact()
	{
		$job = Model_Job::factory()->get_by_id($this->request->param('id'));

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}
		
		$form = Bform::factory('Frontend_Jobs_Contact');

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('jobs.contact');

			$email->set_tags(array(
				'%email.subject%' => $form->subject->get_value(),
				'%email.message%' => $form->message->get_value(),
				'%email.from%' => $form->email->get_value(),
				'%job.title%' => $job->title,
				'%job.link%' => HTML::anchor(
					URL::site(Jobs::uri($job), 'http'), $job->title
				),
			));
			$job->send_email_message($email, NULL, array('reply_to' => $form->email->get_value()));
			
			FlashInfo::add(___('jobs.contact.success'), 'success');
			$this->redirect(Jobs::uri($job));
		}

		$breadcrumbs = $this->_breadcrumb($job);
		$breadcrumbs[$this->template->set_title(___('jobs.contact.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/contact')
			->set('job', $job)
			->set('form', $form);
	}

	public function action_send()
	{
		$job = Model_Job::factory()->get_by_id($this->request->param('id'));

		if(!$job->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$form = Bform::factory('Frontend_Jobs_Send');

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('jobs.send_to_friend');

			$url = Jobs::url($job, 'http');

			$email->set_tags(array(
				'%link%' => HTML::anchor($url),
			));

			$email->send($form->email->get_value());
			FlashInfo::add('jobs.send.success', 'success');

			$this->redirect(Jobs::uri($job));
		}

		$breadcrumbs = $this->_breadcrumb($job);
		$breadcrumbs[$this->template->set_title(___('jobs.send.title'))] = '';
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/send')
			->set('form', $form);
	}

	public function action_search()
	{
		$query = $this->request->query();

		$jobs = $pager = NULL;

		if(!empty($query))
		{
			if(empty($query['phrase']) OR $query['phrase'] == ___('jobs.search.phrase.placeholder'))
			{
				FlashInfo::add('jobs.search.phrase.error');
				$this->redirect_referrer();
			}

			$model_job = new Model_Job();
			$model_job->search_phrase($query['phrase']);

			if(!empty($query['category']))
			{
				$category = new Model_Job_Category((int)$query['category']);

				if($category->loaded())
				{
					$model_job->filter_by_category($category);
				}
			}

			$model_job->filter_by_active();

			$pager = Pagination::factory(array(
				'items_per_page' => 20,
				'total_items' => $model_job->reset(FALSE)->count_all()
			));

			$jobs = $model_job->get_list($pager);
		}

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs['jobs.search.results'] = '';

		breadcrumbs::add($breadcrumbs);

		$this->template->search_params = $query;
		$this->template->content = View::factory('jobs/frontend/search')
			->set('jobs', $jobs)
			->set('pager', $pager);

		$this->template->set_title(___('jobs.search.title'));
	}

	public function action_advanced_search()
	{
		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('jobs.advanced_search.title'))] = URL::site($this->request->uri());

		$jobs = $pager = NULL;

		$query = $this->request->query();

		$form = Bform::factory('Frontend_Jobs_AdvancedSearch', $query);

		if($form->validate())
		{
			$model_job = new Model_Job();
			$model_job->search_phrase($query['phrase'], $query['where']);

			if(!empty($query['category_id']))
			{
				$category = new Model_Job_Category((int)$query['category_id']);

				if($category->loaded())
				{
					$model_job->filter_by_category($category);
				}

				if(!empty($query['attributes']))
				{
					$model_job->filter_by_attributes($category, $query['attributes']);
				}
			}
			
			if(!empty($query['province']))
			{
				$model_job->filter_by_province($query['province']);
			}
			
			if(!empty($query['county']))
			{
				$model_job->filter_by_county($query['county']);
			}
			
			if(!empty($query['city']))
			{
				$model_job->filter_by_city($query['city']);
			}

			$model_job->filter_by_active();

			$pager = Pagination::factory(array(
				'items_per_page' => 20,
				'total_items' => $model_job->reset(FALSE)->count_all()
			));

			$jobs = $model_job->get_list($pager);

			if(count($jobs) == 0)
			{
				FlashInfo::add('jobs.advanced_search.no_results', 'error');
			}
			else
			{
				$breadcrumbs['jobs.advanced_search.results'] = '';
			}
		}

		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/advanced_search')
			->set('form', $form)
			->set('jobs', $jobs)
			->set('pager', $pager);
	}

	public function action_show_by_user()
	{
		$user = Model_User::factory()->find_by_pk($this->request->param('user_id'));

		if(!$user->loaded())
		{
			throw new HTTP_Exception_404();
		}

		$filters = $this->request->query();
		$filters['user'] = $user;

		$model = new Model_Job;

		$pager = Pagination::factory(array(
			'items_per_page' => Arr::get($filters, 'on_page', 20),
			'total_items' => $model->apply_filters($filters)->count_all(),
		));

		$jobs = $model->get_list($pager, $filters);

		$breadcrumbs = $this->_breadcrumb();
		$breadcrumbs[$this->template->set_title(___('jobs.show_by_user.title', array(
			':user_name' => HTML::chars($user->user_name),
		)))] = $this->request->uri();
		breadcrumbs::add($breadcrumbs);

		$this->template->content = View::factory('jobs/frontend/show_by_user')
			->set('filters_sorters', $filters)
			->set('jobs', $jobs)
			->set('pager', $pager)
			->set('user', $user);
	}

}
