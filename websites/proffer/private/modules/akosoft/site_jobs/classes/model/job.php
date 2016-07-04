<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job extends ORM implements IEmailMessageReceiver {

	const DISTINCTION_NONE = 1;
	const DISTINCTION_PREMIUM = 2;
	const DISTINCTION_PREMIUM_PLUS = 3;
	const DISTINCTION_DISTINCTION = 4;

	protected $_table_name = 'jobs';
	protected $_primary_key = 'id';
	protected $_belongs_to = array(
		'last_category' => array('model' => 'Job_Category', 'foreign_key' => 'category_id'),
		'user' => array('model' => 'User', 'foreign_key' => 'user_id'),
		'catalog_company' => array('model' => 'Catalog_Company', 'foreign_key' => 'company_id'),
	);
	protected $_has_many = array(
		'categories' => array('model' => 'Job_Category', 'through' => 'jobs_to_categories', 'foreign_key' => 'id'),
		'attributes' => array('model' => 'Job_Attribute'),
	);
	protected $_created_column = array(
		'column' => 'date_added',
		'format' => 'Y-m-d H:i:s',
	);
	protected $_updated_column = array(
		'column' => 'date_updated',
		'format' => 'Y-m-d H:i:s',
	);
	protected $_contact_data = NULL;

	public function add_job($values)
	{
		if(!empty($values['availability_span']) AND is_numeric($values['availability_span']))
		{
			$this->date_availability = $this->_calculate_availability($values['availability_span']);
			unset($values['availability_span']);
		}

		$this->values($values);

		$this->ip_address = Request::$client_ip;

		$this->save();

		if($this->saved())
		{
			$this->rebuild_category(Arr::get($values, 'category_id'));

			if(isset($values['attributes']))
			{
				$this->save_attributes($values['attributes']);
			}
		}

		return $this;
	}

	public function add_admin_job($values)
	{
		$values['is_paid'] = TRUE;
		$values['is_approved'] = TRUE;

		return $this->add_job($values);
	}

	public function edit_job($values)
	{
		$this->values($values)->save();
		$this->rebuild_category(Arr::get($values, 'category_id'));
	}

	public function edit_admin_job($values)
	{
		return $this->edit_job($values);
	}

	public function save_attributes($values)
	{
		if(!$this->loaded())
		{
			throw new Kohana_Exception('Model is not loaded!');
		}

		$this->attributes->save_attributes($this, $values);
	}

	public function has_category()
	{
		return $this->category_id && $this->last_category->loaded();
	}

	public function get_last_category()
	{
		return $this->last_category;
	}

	public function has_user()
	{
		return $this->user_id AND $this->user->loaded();
	}

	public function get_user()
	{
		return $this->has_user() ? $this->user : NULL;
	}

	public function has_company()
	{
		return Modules::enabled('site_catalog') AND $this->company_id AND $this->catalog_company->loaded();
	}

	public function get_company()
	{
		return $this->has_company() ? $this->catalog_company : NULL;
	}

	public function contact_data()
	{
		if(!$this->loaded() OR ! $this->user->loaded())
		{
			return NULL;
		}

		if($company = $this->get_company())
		{
			$this->_contact_data = $company->get_contact();
		}
		else
		{
			$this->_contact_data = Contact::factory($this->person_type);
			$this->_contact_data->name = $this->person;
			$this->_contact_data->phone = $this->telephone;
			$this->_contact_data->email = $this->email;
			$this->_contact_data->www = $this->www;

			if(!$this->_contact_data->email AND $user = $this->get_user())
			{
				$this->_contact_data->email = $user->get_email_address();
			}

			$address = new Address();
			$address->province_id = $this->province;
			$address->province = Regions::province($this->province);
			$address->county_id = $this->county;
			$address->county = Regions::county($this->county, $this->province);
			$address->postal_code = $this->postal_code;
			$address->city = $this->city;
			$address->street = $this->street;

			$this->_contact_data->address = $address;
		}

		return $this->_contact_data;
	}

	public function search_phrase($phrase, $where = 'title_and_description')
	{
		$phrase = UTF8::trim($phrase);

		if(UTF8::strlen($phrase) >= 4)
		{
			if($where == 'title')
			{
				$where = $this->_db->quote_column('title');
			}
			elseif($where == 'description')
			{
				$where = $this->_db->quote_column("content");
			}
			else
			{
				$where = $this->_db->quote_column('title').','.$this->_db->quote_column('content');
			}

			$this->where(DB::expr('MATCH('.$where.')'), "AGAINST", DB::expr("(:phrase IN BOOLEAN MODE)"))
				->param(':phrase', $phrase);
		}
		else
		{
			$phrase = '%'.$phrase.'%';

			if($where == 'title')
			{
				$this->where('title', 'LIKE', $phrase);
			}
			elseif($where == 'description')
			{
				$this->where('content', 'LIKE', $phrase);
			}
			else
			{
				$this->where_open();
				$this->where('title', 'LIKE', $phrase);
				$this->or_where('content', 'LIKE', $phrase);
				$this->where_close();
			}
		}

		return $this;
	}

	public function filter_by_main_category($category)
	{
		if($category instanceof Model_Job_Category)
		{
			return $this->where($this->object_name().'.category_id', '=', $category->pk());
		}

		return $this->where($this->object_name().'.category_id', is_array($category) ? 'IN' : '=', $category);
	}

	public function filter_by_category(Model_Job_Category $category)
	{
		$categories = $category->get_descendants(TRUE);

		if(count($categories))
		{
			return $this->where($this->object_name().'.category_id', 'IN', $categories->as_array(NULL, 'category_id'));
		}

		return $this;
	}

	public function filter_by_prices($price_from = NULL, $price_to = NULL)
	{
		if(!empty($price_from))
		{
			$this->where('price', '>', $price_from);
		}

		if(!empty($price_to))
		{
			$this->where('price', '<', $price_to);
		}

		return $this;
	}

	public function filter_by_province($province)
	{
		return $this->where('province', '=', (int)$province);
	}

	public function filter_by_county($county)
	{
		return $this->where('county', '=', (int)$county);
	}

	public function filter_by_city($city)
	{
		return $this->where('city', 'LIKE', $city);
	}

	public function filter_by_user($user)
	{
		if($user instanceof Model_User)
		{
			$user = $user->pk();
		}

		return $this->where($this->object_name().'.user_id', '=', (int)$user);
	}

	public function filter_by_attributes(Model_Job_Category $category, $attributes)
	{
		$fields = $category->get_fields();

		foreach($fields as $field)
		{
			if(!empty($attributes[$field->name]))
			{
				$tbl_alias = 'attr_'.$field->name;

				$this->join(array('job_attributes', $tbl_alias))
					->on($tbl_alias.'.job_id', '=', $this->object_name().'.'.$this->primary_key())
					->on($tbl_alias.'.category_field_id', '=', DB::expr($field->pk()));

				$this->on($tbl_alias.'.value', '=', DB::expr($this->_db->escape($attributes[$field->name])));
			}
		}
	}

	public function filter_by_promoted($distinction = NULL)
	{
		if(!$distinction)
		{
			$distinction = array(self::DISTINCTION_PREMIUM, self::DISTINCTION_PREMIUM_PLUS);
		}

		$this->where($this->object_name().'.distinction', 'IN', (array)$distinction);
		$this->where($this->object_name().'.date_promotion_availability', '>', date('Y-m-d H:i:s'));

		return $this;
	}

	public function with_count_replies()
	{
		$model = new Model_Job_Reply();

		$this->select(array('count_replies_tbl.count_replies', 'count_replies'));

		$this->join(array(
				DB::select('job_id', array(DB::expr('COUNT(id)'), 'count_replies'))
				->from($model->table_name())
				->group_by('job_id'),
				'count_replies_tbl'
				), 'LEFT')
			->on('count_replies_tbl.job_id', '=', $this->object_name().'.'.$this->primary_key());

		return $this;
	}

	public function get_attributes($not_empty = FALSE)
	{
		$model = new Model_Job_Attribute;

		if($not_empty)
		{
			$model->filter_by_not_empty();
		}

		return $model->find_for_job($this);
	}

	public function get_availability_days_left()
	{
		return ceil((strtotime($this->date_availability) - time()) / Date::DAY);
	}

	public function can_renew()
	{
		return $this->get_availability_days_left() <= 10;
	}

	public function renew($availability)
	{
		$this->date_availability = $this->_calculate_availability($availability, strtotime($this->date_availability));
		$this->visits = 0;
		$this->save();
	}

	public function renew_admin($date)
	{
		$this->date_availability = $date;
		$this->visits = 0;
		$this->save();
	}

	public function is_approved()
	{
		return $this->is_approved;
	}

	public function is_archived()
	{
		return strtotime($this->date_availability) < time();
	}

	public function set_paid()
	{
		$this->is_paid = 1;
		$this->save();

		return $this->saved();
	}

	public function approve()
	{
		$this->is_approved = 1;
		$this->save();

		return $this->saved();
	}

	public function find_user_job($id, Model_User $user)
	{
		$this->filter_by_user($user);
		return $this->find_by_pk($id);
	}

	public function find_promoted_home($limit = NULL)
	{
		if($limit)
		{
			$this->limit($limit);
		}

		$this->filter_by_active();
		$this->filter_by_promoted(self::DISTINCTION_PREMIUM_PLUS);

		$this->with_count_replies();

		$this->order_by(DB::expr('RAND()'));

		return $this->find_all();
	}

	public function find_recent_home($limit = NULL)
	{
		if($limit)
		{
			$this->limit($limit);
		}

		$this->filter_by_active();

		$this->with_count_replies();

		$this->apply_ordering('date_added', 'DESC');

		return $this->find_all();
	}

	public function search_advanced($data, $limit, $offset)
	{
		if(empty($data['phrase']) AND empty($data['price_from']) AND empty($data['price_to']) AND empty($data['category']) AND empty($data['city']) AND empty($data['province_select']))
		{
			return FALSE;
		}

		$this->order_by('date_added', 'DESC');

		$this->filter_by_active();

		$this->with('sub_category');

		$this->limit($limit)->offset($offset);

		return $this->find_all();
	}

	public function get_all($offset, $limit, array $filters)
	{
		$this->apply_ordering(TRUE);

		$this->apply_filters($filters);

		if(!empty($filters['sort_by']))
		{
			$this->apply_ordering(Arr::get($filters, 'sort_by'), Arr::get($filters, 'sort_direction'));
		}
		else
		{
			$this->apply_ordering(FALSE);
		}

		$this->with_count_replies();

		$this->limit($limit);
		$this->offset($offset);

		return $this->find_all();
	}

	public function get_list(Pagination $pagination = NULL, $filters = NULL)
	{
		if($pagination)
		{
			$this->limit($pagination->items_per_page)
				->offset($pagination->offset);
		}

		$this->filter_by_active();

		$this->with_count_replies();

		$this->apply_ordering(TRUE);

		$this->apply_filters($filters);

		if(!empty($filters['sort_by']))
		{
			$this->apply_ordering(Arr::get($filters, 'sort_by'), Arr::get($filters, 'sort_direction'));
		}
		else
		{
			$this->apply_ordering(FALSE);
		}

		return $this->find_all();
	}

	public function get_by_id($id, $preview = FALSE, $allow_archived = FALSE)
	{
		if(!$preview)
		{
			$this->filter_by_active($allow_archived);
		}

		return $this->find_by_pk($id);
	}

	public function inc_visits()
	{
		$this->visits = $this->visits + 1;
		$this->save();
	}

	public function is_promoted()
	{
		return in_array($this->distinction, array(
				self::DISTINCTION_PREMIUM, self::DISTINCTION_PREMIUM_PLUS,
			)) AND strtotime($this->date_promotion_availability) > time();
	}

	public function promote($distinction)
	{
		$days = (int)Jobs::config('promotion_time');

		$promotion_availability_timestamp = time() + (60 * 60 * 24 * $days);

		$this->is_paid = TRUE;
		$this->distinction = (int)$distinction;
		$this->date_promotion_availability = date('Y-m-d H:i:s', $promotion_availability_timestamp);

		$availability_timestamp = strtotime($this->date_availability);

		if($promotion_availability_timestamp > $availability_timestamp)
		{
			$this->date_availability = date('Y-m-d H:i:s', $promotion_availability_timestamp);
		}

		$this->save();
	}

	public function count_admin($filters)
	{
		$this->_apply_filters_admin($filters);
		return $this->count_all();
	}

	public function get_admin(array $filters, $offset, $limit)
	{
		$this->_apply_filters_admin($filters);
		$this->with('user');
		$this->order_by('id', 'DESC');
		$this->offset($offset)->limit($limit);
		return $this->find_all();
	}

	protected function _apply_filters_admin(array $filters)
	{
		if(!empty($filters['which']))
		{
			switch($filters['which'])
			{
				case 'standard':
					$this
						->where_open()
						->where('distinction', '=', self::DISTINCTION_NONE)
						->or_where('distinction', '=', 0)
						->where_close();
					break;

				case 'promoted':
					$this->where_open();
					$this->where('distinction', '=', self::DISTINCTION_PREMIUM);
					$this->or_where('distinction', '=', self::DISTINCTION_PREMIUM_PLUS);
					$this->where_close();
					$this->where('date_promotion_availability', '>', DB::expr('NOW()'));
					break;

				case 'not_active':
					$this->where('date_availability', '<', DB::expr('NOW()'));
					break;

				case 'active':
					$this->where('date_availability', '>', DB::expr('NOW()'));
					$this->where('is_approved', '=', 1);
					break;

				case 'not_approved':
					$this->where('is_approved', '=', 0);
					break;

				default:
					throw new Exception('check api!');
					break;
			}
		}
		if(!empty($filters['user_id']))
		{
			$this->where('job.user_id', '=', $filters['user_id']);
		}

		if(!empty($filters['primary_key']))
		{
			$this->where($this->primary_key(), '=', (int)$filters['primary_key']);
		}
	}

	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}

		$jobs = DB::select('job_id')
			->from('jobs_to_categories')
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->group_by('job_id')
			->execute($this->_db)
			->as_array(NULL, 'job_id');

		$this->delete_jobs($jobs);
	}

	public function delete_jobs($jobs)
	{
		if(empty($jobs))
		{
			return;
		}

		$categories = new Model_Job_To_Category;
		$categories->delete_by_job($jobs);

		$closet = new Model_Job_Closet();
		$closet->delete_by_job($jobs);

		$attributes = new Model_Job_Attribute;
		$attributes->delete_by_job($jobs);

		$replies = new Model_Job_Reply();
		$replies->delete_by_job($jobs);

		$comment = new Model_Job_Comment();
		$comment->delete_by_job($jobs);

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $jobs)
			->execute();
	}

	public function delete()
	{
		if(!$this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));

		$this->delete_jobs(array($this->pk()));

		$this->clear();

		return $this;
	}

	public function query_active($query, $allow_archived = FALSE)
	{
		if(!$allow_archived)
		{
			$query->where($this->object_name().'.date_availability', '>', date('Y-m-d H:i:s'));
		}

		$query->where($this->object_name().'.is_approved', '=', 1);
		$query->where($this->object_name().'.is_paid', '=', 1);

		return $query;
	}

	public function filter_by_active($allow_archived = FALSE)
	{
		return $this->query_active($this, $allow_archived);
	}

	public function filter_by_inactive()
	{
		$this->and_where_open();
		$this->where($this->object_name().'.date_availability', '<', date('Y-m-d H:i:s'));
		$this->or_where($this->object_name().'.is_approved', '=', 0);
		$this->or_where($this->object_name().'.is_paid', '=', 0);
		$this->and_where_close();

		return $this;
	}

	protected function _calculate_availability($days, $now = FALSE)
	{
		if($now === FALSE)
		{
			$now = time();
		}
		$availability = $now + ($days * 60 * 60 * 24);
		return date('Y-m-d H:i:s', $availability);
	}

	public function apply_filters($filters)
	{
		if(!empty($filters['status']))
		{
			if($filters['status'] == 'not_active')
			{
				$this->filter_by_inactive();
			}
			elseif($filters['status'] == 'active')
			{
				$this->filter_by_active();
			}
		}

		if(!empty($filters['closet_user']))
		{
			$model_closet = new Model_Job_Closet;
			$model_closet->build_query_user_closet($this, $filters['closet_user']);
		}

		if(!empty($filters['user_id']))
		{
			$this->filter_by_user($filters['user_id']);
		}

		if(!empty($filters['promoted']))
		{
			$this->filter_by_promoted();
		}

		if(!empty($filters['category']))
		{
			$this->filter_by_category($filters['category']);
		}

		if(!empty($filters['category_id']))
		{
			$this->join('jobs_to_categories')->on('job.id', '=', 'jobs_to_categories.job_id')
				->where('jobs_to_categories.category_id', '=', $filters['category_id'])
				->group_by('job.'.$this->primary_key());
		}

		if(!empty($filters['province']))
		{
			$this->filter_by_province($filters['province']);
		}

		if(!empty($filters['county']))
		{
			$this->filter_by_county($filters['county']);
		}

		if(!empty($filters['city']))
		{
			$this->filter_by_city($filters['city']);
		}

		return $this;
	}

	public function apply_ordering($column = NULL, $direction = NULL)
	{
		if($column === TRUE)
		{
			$direction = strtolower($direction) == 'asc' ? 'ASC' : 'DESC';

			$this->order_by(DB::expr('IF('.$this->_db->quote_column($this->object_name().'.distinction').' IN('.implode(',', array(
				self::DISTINCTION_PREMIUM, self::DISTINCTION_PREMIUM_PLUS,
			)).') AND '.$this->_db->quote_column($this->object_name().'.date_promotion_availability').'>'.$this->_db->quote(date('Y-m-d H:i:s')).', '.$this->_db->quote_column($this->object_name().'.distinction').', 0)'), 'DESC');

			return;
		}

		if(!$column)
		{
			$column = 'date_added';
			$direction = 'DESC';
		}

		$direction = strtolower($direction) == 'desc' ? 'DESC' : 'ASC';

		switch($column)
		{
			case 'date_added':
				$this->order_by('date_added', $direction);
				break;

			case 'price':
				$this->order_by('price', $direction);
				break;
		}
	}

	public function rebuild_category($category_id)
	{
		if(!$category_id)
		{
			return;
		}

		DB::delete('jobs_to_categories')->where('job_id', '=', $this->pk())->execute();

		$category = new Model_Job_Category();
		$category->find_by_pk($category_id);

		if($category->loaded())
		{
			$categories = Model_Job_Category::factory()->get_path($category);

			if(count($categories))
			{
				$insert_query = DB::insert('jobs_to_categories')->columns(array(
					'job_id', 'category_id',
				));

				foreach($categories as $category)
				{
					$insert_query->values(array(
						'job_id' => $this->pk(),
						'category_id' => $category->pk(),
					));
				}

				$insert_query->execute($this->_db);
			}
		}
	}

	public function get_rss()
	{
		$this->filter_by_active();
		$this->limit(50);
		$this->order_by($this->object_name().'.date_added', 'DESC');

		return $this->find_all();
	}

	public function find_jobs_for_notifier(Model_Notifier $notifier)
	{
		$job = new self();
		$job->filter_by_active();
		$job->select('job_categories.*')
			->where('is_notifier_sent', '=', 0)
			->join('jobs_to_categories', 'RIGHT')
			->on('jobs_to_categories.job_id', '=', 'job.id')
			->join('job_categories', 'RIGHT')
			->on('jobs_to_categories.category_id', '=', 'job_categories.category_id')
			->where('jobs_to_categories.category_id', 'IN', $notifier->get_categories())
			->group_by('job.id')
			->order_by('jobs_to_categories.category_id');
		
		if(Jobs::config('provinces_enabled') AND !empty($notifier->notify_provinces))
		{
			$job->filter_by_province($notifier->notify_provinces);
		}

		return $job->find_all();
	}

	public function mark_notified()
	{
		$query = DB::update(array($this->table_name(), $this->object_name()))
			->set(array('is_notifier_sent' => TRUE))
			->where('is_notifier_sent', '=', 0);

		$this->query_active($query);

		return $query->execute();
	}

	public function find_expired()
	{
		$this->query_active($this, TRUE);

		return $this->with_count_replies()
				->where('is_expired_send', '=', FALSE)
				->where('job.date_availability', '<=', date('Y-m-d H:i:s'))
				->where(DB::expr('DATEDIFF(job.date_availability, NOW())'), '<=', 0)
				->find_all();
	}

	public function mark_expired()
	{
		$query = DB::update(array($this->table_name(), $this->object_name()))
			->set(array('is_expired_send' => TRUE))
			->where('is_expired_send', '=', 0)
			->where('job.date_availability', '<=', date('Y-m-d H:i:s'))
			->where(DB::expr('DATEDIFF(job.date_availability, NOW())'), '<=', 0);

		$this->query_active($query, TRUE);

		return $query->execute();
	}

	public static function count_jobs()
	{
		$self = new self();
		$self->filter_by_active();

		return $self->count_all();
	}

	public function get_email_address()
	{
		return $this->contact_data()->email;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}

		return Email::send($this->get_email_address(), $subject, $message, $params);
	}

	public function send_comment_add(Model_Job_Comment $comment)
	{
		$email = Model_Email::email_by_alias('jobs.comment_add');

		if($email AND $email->loaded())
		{
			$email->set_tags(array(
				'%job.id%' => $this->pk(),
				'%job.title%' => HTML::chars($this->title),
				'%job.url%' => URL::site(Jobs::uri($this), 'http'),
				'%comment.body%' => HTML::chars($comment->body),
				'%comment.user.name%' => HTML::chars($comment->get_user()->user_name),
				'%comment.user.email%' => HTML::chars($comment->get_user()->user_email),
			));

			return $this->send_email_message($email);
		}

		return FALSE;
	}

	public function send_reply_add(Model_Job_Reply $reply)
	{
		$email = Model_Email::email_by_alias('jobs.reply_add');

		if($email AND $email->loaded())
		{
			$email->set_tags(array(
				'%job.id%' => $this->pk(),
				'%job.title%' => HTML::chars($this->title),
				'%job.url%' => URL::site(Jobs::uri($this), 'http'),
				'%reply.content%' => HTML::chars($reply->content),
				'%reply.price%' => $reply->price ? payment::price_format($reply->price) : '',
				'%reply.price_unit%' => Arr::get(Model_Job_Reply::get_price_units(), $reply->price_unit),
				'%reply.user.name%' => HTML::chars($reply->get_user()->user_name),
				'%reply.user.email%' => HTML::chars($reply->get_user()->user_email),
			));

			return $this->send_email_message($email, NULL, array(
					'reply_to' => $reply->get_email_address(),
			));
		}

		return FALSE;
	}

}
