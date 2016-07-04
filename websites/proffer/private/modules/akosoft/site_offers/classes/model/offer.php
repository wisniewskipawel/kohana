<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Model_Offer extends ORM implements IEmailMessageReceiver {

	use Trait_ImageModel;

	const DISTINCTION_NONE = 1;
	const DISTINCTION_PREMIUM = 2;
	const DISTINCTION_PREMIUM_PLUS = 3;
	const DISTINCTION_DISTINCTION = 4;

	protected $_table_name = 'offers';
	protected $_primary_key = 'offer_id';
	protected $_primary_val = 'offer_title';

	protected $_belongs_to = array(
		'user'			=> array('model' => 'User', 'foreign_key' => 'user_id'),
		'user_closet'		=> array('model' => 'User', 'through' => 'Offers_To_Users', 'foreign_key' => 'user_id'),
		'catalog_company'	=> array('model' => 'Catalog_Company', 'foreign_key' => 'company_id'),
		'last_category'		=> array('model' => 'Offer_Category', 'foreign_key' => 'category_id'),
	);

	protected $_has_many = array(
		'images'			=> array('model' => 'Image', 'foreign_key' => 'object_id'),
		'categories'		=> array('model' => 'Offer_Category', 'through' => 'offers_to_categories', 'foreign_key' => 'offer_id'),
	);

	protected $_created_column = array(
		'column' => 'offer_date_added',
		'format' => 'Y-m-d H:i:s',
	);

	protected $_updated_column = array(
		'column' => 'offer_date_updated',
		'format' => 'Y-m-d H:i:s',
	);
	
	protected $_contact_data = NULL;

	public function is_distinct()
	{
		return $this->offer_distinction == self::DISTINCTION_DISTINCTION;
	}

	public function add_to_closet($user_id) 
	{
		$values['user_id'] = $user_id;
		$values['offer_id'] = $this->pk();

		$count = ORM::factory('Offer_To_User')->where('user_id', '=', $values['user_id'])->where('offer_id', '=', $values['offer_id'])->count_all();

		if ($count) 
		{
			return;
		}

		$relation = ORM::factory('Offer_To_User')->values($values)->save();
	}

	public function search_phrase($phrase, $where = 'title_and_description')
	{
		$phrase = UTF8::trim($phrase);

		if(UTF8::strlen($phrase) >= 4)
		{
			if($where == 'title')
			{
				$where = $this->_db->quote_column('offer_title');
			}
			elseif($where == 'description')
			{
				$where = $this->_db->quote_column("offer_content");
			}
			else
			{
				$where = $this->_db->quote_column("offer_title").','.$this->_db->quote_column("offer_content");
			}

			$this->where(DB::expr('MATCH('.$where.')'), "AGAINST", DB::expr("(:phrase IN BOOLEAN MODE)"))
				->param(':phrase', $phrase);
		}
		else
		{
			$phrase = '%'.$phrase.'%';

			if($where == 'title')
			{
				$this->where('offer_title', 'LIKE', $phrase);
			}
			elseif($where == 'description')
			{
				$this->where('offer_content', 'LIKE', $phrase);
			}
			else
			{
				$this->where_open();
				$this->where('offer_title', 'LIKE', $phrase);
				$this->or_where('offer_content', 'LIKE', $phrase);
				$this->where_close();
			}

		}

		return $this;
	}

	public function filter_by_category($category)
	{
		return $this->where($this->object_name().'.category_id', is_array($category) ? 'IN' : '=', $category);
	}

	public function filter_by_prices($price_from = NULL, $price_to = NULL)
	{
		if (!empty($price_from))
		{
			$this->where('offer_price', '>', $price_from);
		}

		if (!empty($price_to))
		{
			$this->where('offer_price', '<', $price_to);
		}

		return $this;
	}

	public function filter_by_province($province)
	{
		$province = (int)$province;
		
		$this->where_open();
		
		$this->where($this->object_name().'.province_select', '=', $province);
		
		if(Modules::enabled('site_catalog'))
		{
			$this->with('catalog_company');
			$this->or_where('catalog_company.province_select', '=', $province);
		}
		
		return $this->where_close();
	}

	public function filter_by_county($county)
	{
		$county = (int)$county;
		
		$this->where_open();
		
		$this->where($this->object_name().'.offer_county', '=', $county);
		
		if(Modules::enabled('site_catalog'))
		{
			$this->with('catalog_company');
			$this->or_where('catalog_company.company_county', '=', $county);
		}
		
		return $this->where_close();
	}

	public function filter_by_city($city)
	{
		$this->where_open();
		
		$this->where($this->object_name().'.offer_city', 'LIKE', $city);
		
		if(Modules::enabled('site_catalog'))
		{
			$this->with('catalog_company');
			$this->or_where('catalog_company.company_city', 'LIKE', $city);
		}
		
		return $this->where_close();
	}

	public function filter_by_company($company)
	{
		if(!Modules::enabled('site_catalog'))
		{
			throw new Kohana_Exception('Cannot filter by company! Module site_catalog is disabled!');
		}
		
		return $this->where($this->object_name().'.company_id', '=',
			(int)($company instanceof Model_Catalog_Company ? $company->pk() : $company)
		);
	}

	public function filter_by_today_ending()
	{
		return $this->where(DB::expr("DATEDIFF(DATE(offer_availability), '".date('Y-m-d')."')"), '=', '0');
	}

	public function filter_by_closet_user(Model_User $user)
	{
		return $this->join('offers_to_users', 'RIGHT')->on('offer.offer_id', '=', 'offers_to_users.offer_id');
			$this->where('offers_to_users.user_id', '=', $user->pk());
	}

	public function filter_by_user(Model_User $user)
	{
		return $this->where($this->object_name().'.user_id', '=', (int)$user->pk());
	}

	public function is_active()
	{
		return $this->loaded() && $this->is_paid() && !$this->is_expired() && !$this->is_download_limit_exceeded();
	}

	public function is_expired()
	{
		return time() > strtotime($this->offer_availability);
	}

	public function is_nolimit()
	{
		return $this->download_limit == 0;
	}

	public function is_download_limit_exceeded()
	{
		if($this->is_nolimit())
			return FALSE;

		return $this->download_limit <= $this->download_counter;
	}
	
	public function is_paid()
	{
		return $this->offer_is_paid;
	}
	
	public function set_paid()
	{
		$this->offer_is_paid = TRUE;
		$this->offer_is_approved = TRUE;
		$this->save();
	}

	public function contact_data()
	{
		if(!$this->loaded())
		{
			return NULL;
		}
		
		if($this->_contact_data)
		{
			return $this->_contact_data;
		}
		
		if($this->has_company())
		{
			$this->_contact_data = $this->catalog_company->get_contact();
		}
		else
		{
			$this->_contact_data = Contact::factory($this->offer_person_type ? $this->offer_person_type : Contact::TYPE_PERSON);
			$this->_contact_data->name = $this->offer_person;
			$this->_contact_data->phone = $this->offer_telephone;
			$this->_contact_data->email = $this->get_email_address();
			$this->_contact_data->www = $this->offer_www;

			$address = new Address();
			$address->province_id = $this->province_select;
			$address->province = offers::province_to_text($this->province_select);
			$address->county_id = $this->offer_county;
			$address->county = Regions::county($this->offer_county, $this->province_select);
			$address->postal_code = $this->offer_postal_code;
			$address->city = $this->offer_city;
			$address->street = $this->offer_street;

			$this->_contact_data->address = $address;
		}
		
		return $this->_contact_data;
	}

	public function get_price_old()
	{
		return $this->offer_price_old;
	}
	
	public function get_price_new()
	{
		return $this->offer_price;
	}
	
	public function get_discount()
	{
		if($this->offer_price_old <= 0)
			return 0;
		
		return round((($this->offer_price_old - $this->offer_price) / $this->offer_price_old) * 100);
	}

	public function get_days_left()
	{
		$offset = strtotime($this->offer_availability) - time();
		
		if($offset <= 0)
		{
			return 0;
		}
		
		return ceil($offset / Date::DAY);
	}
	
	public function get_limit()
	{
		if($this->is_nolimit())
		{
			return $this->limit_per_user;
		}
		else
		{
			if($this->get_active_coupon_counter() > 0)
			{
				if($this->get_active_coupon_counter() > $this->limit_per_user)
				{
					return $this->limit_per_user;
				}
				else
				{
					return $this->get_active_coupon_counter();
				}
			}
		}
		
		return 0;
	}
	
	public function can_renew()
	{
		return $this->get_days_left() <= 10;
	}

	public function renew($values) 
	{
		$this->values($values);
		$this->offer_visits = 0;
		$this->save();
	}

	public function add_offer($values, $files)
	{
		$this->values($values);

		do
		{
			$hash = Text::random('alnum', 32);
		}
		while (!$this->unique('offer_hash', $hash));

		$this->offer_hash = $hash;
		$this->offer_availability = Arr::get($values, 'offer_availability');
		$this->ip_address = Request::$client_ip;

		$this->save();

		$this->_rebuild_category($values);

		foreach ($files as $f) {
			$this->add_image($f);
		}

		return $this;
	}

	public function edit_offer(array $values)
	{
		if (array_key_exists('offer_is_approved', $values) AND $values['offer_is_approved'] != $this->offer_is_approved AND $values['offer_is_approved'])
		{
			$this->approve();
		}
		$this->values($values)->save();
		$this->_rebuild_category($values);
	}

	public function approve()
	{
		$this->offer_is_approved = 1;
		$this->save();
	}

	/**
	 * @return ImageManager
	 */
	public function get_image_manager()
	{
		return new ImageManager('offer', 'offers', 'offers');
	}

	/**
	 * @param $file
	 * @return bool
	 * @throws Kohana_Exception
	 */
	public function add_image($file) 
	{
		$path = Upload::save($file);
		return $this->get_image_manager()->save_image($path, $this->pk());
	}

	public function get_image($image_id) 
	{
		return $this->images
				->where('object_type', '=', 'offer')
				->where('image_id', '=', (int)$image_id)
				->find();
	}

	public function apply_sorting($order_by, $is_list = TRUE)
	{
		if($order_by && in_array('status', array_keys($order_by)))
		{
			$this->order_by(DB::expr(
				'IF(offer_availability <= NOW() OR offer_is_approved !=1 OR (download_limit > 0 AND download_counter >= download_limit),0,1)'
			), 'DESC');
		}
		
		if($is_list)
		{
			$this->order_by(
				DB::expr('IF(offer_distinction IN ('.self::DISTINCTION_PREMIUM.', '.self::DISTINCTION_PREMIUM_PLUS.')
						AND offer_promotion_availability > NOW(), 1, 0)'),
				'DESC'
			);
		}

		if($order_by == 'random')
		{
			return $this->order_by(DB::expr('RAND()'));
		}

		if(is_array($order_by) && !empty($order_by))
		{
			foreach($order_by as $field => $direction)
			{
				$direction = UTF8::strtolower($direction) == 'desc' ? 'DESC' : 'ASC';

				switch($field)
				{
					case 'date_added':
						$this->order_by('offer_date_added', $direction);
						break;

					case 'price':
						$this->order_by('offer_price', $direction);
						break;

					case  'closet':
						$this->order_by('offers_to_users.offer_to_user_id', $direction);
						break;

					case  'popular':
						$this->order_by('offer_visits', $direction);
						break;

					default:
						continue;
				}
			}
		}

		return $this;
	}

	public function get_promoted($limit, $random=FALSE)
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->add_image_to_list();
		$this->add_active_conditions();
		$this->add_last_category();

		$this->custom_select();

		$this->having('is_promoted', '=', 1);
		$this->where('offer_distinction', '=', self::DISTINCTION_PREMIUM_PLUS);

		if($random)
		{
			$this->order_by(DB::expr('RAND()'));
		}

		return $this->find_all();
	}

	public function get_last($limit)
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->order_by('offer_date_added', 'DESC');

		$this->add_image_to_list();
		$this->add_active_conditions();
		$this->add_last_category();

		return $this->find_all();
	}

	public function get_popular($limit, $random = FALSE)
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->order_by('offer_visits', 'DESC');

		$this->add_image_to_list();
		$this->add_active_conditions();
		$this->add_last_category();

		if($random)
		{
			$this->order_by(DB::expr('RAND()'));
		}

		return $this->find_all();
	}

	public function get_recommended($limit)
	{
		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->add_active_conditions();
		$this->add_image_to_list();
		$this->add_last_category();
		
		$this->order_by(DB::expr('RAND()'));
		$this->limit($limit);
		return $this->find_all();
	}

	public function search_advanced($data, $limit, $offset)
	{
		if (empty($data['phrase']) AND empty($data['price_from']) AND empty($data['price_to']) AND empty($data['category']) AND empty($data['city']) AND empty($data['province_select']))
		{
			return FALSE;
		}

		$this->order_by('offer_date_added', 'DESC');

		$this->add_active_conditions();
		$this->add_image_to_list();
		$this->add_last_category();
		$this->custom_select();

		$this->add_image_to_list();
		$this->with('sub_category');

		$this->limit($limit)->offset($offset);

		return $this->find_all();
	}

	public function  get_all($offset, $limit, array $filters)
	{
		$this->_apply_filters($filters);

		$this->add_image_to_list();
		$this->add_last_category();
		$this->custom_select();
		$this->limit($limit);
		$this->offset($offset);

		return $this->find_all();
	}

	public function get_rss()
	{
		$this->add_active_conditions();
		$this->add_image_to_list();
		$this->custom_select();
		$this->limit(50);
		$this->order_by($this->object_name().'.offer_date_added', 'DESC');

		return $this->find_all();
	}

	public function prepare_list_query($filters = NULL, $allow_sort = TRUE)
	{
		$this->with('last_category')
			->custom_select()
			->add_last_category();

		if($allow_sort)
		{
			$this->order_by('is_promoted', 'DESC');
		}

		$this->_apply_filters($filters, $allow_sort);

		return $this;
	}

	public function get_list($pagination_or_limit = NULL, $filters = NULL, $sorting =  NULL)
	{
		if($pagination_or_limit)
		{
			if($pagination_or_limit instanceof Pagination)
			{
				$this->limit($pagination_or_limit->items_per_page)
					->offset($pagination_or_limit->offset);
			}
			else
			{
				$this->limit($pagination_or_limit);
			}
		}

		$this->prepare_list_query($filters);
		$this->apply_sorting($sorting, TRUE);

		return $this->find_all();
	}

	public function count_all_list(array $filters)
	{
		$this->_apply_filters($filters);

		$this->add_active_conditions();
		$this->custom_select();
		return count($this->find_all());
	}

	public function has_last_category()
	{
		return $this->category_id && $this->last_category->loaded();
	}

	public function has_company()
	{
		return Modules::enabled('site_catalog') && $this->company_id && $this->catalog_company->loaded();
	}

	public function get_categories()
	{
		return $this->categories
				->order_by('offer_category.category_level', 'ASC')
				->find_all();
	}

	public function get_last_category()
	{
		return  $this->categories
				->order_by('offer_category.category_level', 'DESC')
				->find();
	}

	public function get_by_id($id, $preview = FALSE)
	{
		$this->where('offer_id', '=', $id);
		if ( ! $preview)
		{
			$this->add_active_conditions();
		}
		$this->add_last_category();
		$this->group_by('offer_id');

		return $this->find();
	}

	public function get_user_offer($offer_id, $user_id) 
	{
		$this->custom_select();
		$this->where('offer_id', '=', $offer_id);
		$this->where('user_id', '=', $user_id);
		return $this->find();
	}

	public function inc_visits()
	{
		$this->offer_visits = $this->offer_visits + 1;
		$this->save();
	}

	public function is_promoted()
	{
		if(isset($this->is_promoted))
			return (bool) $this->is_promoted;

		return $this->loaded()
			&& in_array($this->offer_distinction, array(
				self::DISTINCTION_PREMIUM, self::DISTINCTION_PREMIUM_PLUS,
			))
			&& strtotime($this->offer_promotion_availability) > time();
	}
	
	public function promote(array $values, $approve = FALSE)
	{
		$days = (int) Kohana::$config->load('modules.site_offers.settings.promotion_time');

		$promotion_availability_timestamp = time() + (60 * 60 * 24 * $days);

		$this->offer_distinction = $values['offer_distinction'];
		$this->offer_promotion_availability = date('Y-m-d H:i:s', $promotion_availability_timestamp);
		$this->offer_is_paid = TRUE;
		
		if($approve)
		{
			$this->offer_is_approved = TRUE;
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
		$this->order_by('offer_id', 'DESC');
		$this->offset($offset)->limit($limit);
		$this->custom_select();
		return $this->find_all();
	}

	protected function _apply_filters_admin(array $filters)
	{
		if ( ! empty($filters['which']))
		{
			switch ($filters['which'])
			{
				case 'standard':
					$this
						->where_open()
						->where('offer_distinction', '=', self::DISTINCTION_NONE)
						->or_where('offer_distinction', '=', 0)
						->where_close();
					break;

				case 'promoted':
					$this->where_open();
					$this->where('offer_distinction', '=', self::DISTINCTION_PREMIUM);
					$this->or_where('offer_distinction', '=', self::DISTINCTION_PREMIUM_PLUS);
					$this->where_close();
					$this->where('offer_promotion_availability', '>', DB::expr('NOW()'));
					break;

				case 'not_active':
					$this->filter_by_inactive();
					break;

				case 'active':
					$this->add_active_conditions();
					break;

				case 'not_approved':
					$this->where('offer_is_approved', '=', 0);
					break;

				default:
					throw new Exception('check api!');
					break;
			}
		}
		
		if ( ! empty($filters['user_id'])) 
		{
			$this->where('offer.user_id', '=', $filters['user_id']);
		}
	}
	
	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}
		
		$offers = DB::select('offer_id')
			->from('offers_to_categories')
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->group_by('offer_id')
			->execute($this->_db)
			->as_array(NULL, 'offer_id');
		
		$this->delete_offers($offers);
	}
	
	public function delete_offers($offers)
	{
		if(empty($offers))
		{
			return;
		}
		
		$categories = new Model_Offer_To_Category;
		$categories->delete_by_offer($offers);
		
		$closet = new Model_Offer_To_User();
		$closet->delete_by_offer($offers);
		
		$coupons = new Model_Coupon_Owner();
		$coupons->delete_by_offer($offers);
		
		$this->get_image_manager()->delete_by_object($offers);
		
		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $offers)
			->execute();
	}

	public function delete()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));
		
		$this->delete_offers(array($this->pk()));
		
		$this->clear();
		
		return $this;
	}

	public function add_image_to_list()
	{
		$this
			->select('image.image_id', 'image.image')
			->join(array(
				DB::select('image_id', 'image', 'object_id')
					->from('images')
					->where('object_type', '=', 'offer')
					->order_by('image_id', 'ASC')
				, 'image'), 'LEFT')
			->on('image.object_id', '=', 'offer.offer_id')
			->group_by('offer.offer_id');

		return $this;
	}

	public function query_active($query, $allow_archived = FALSE)
	{
		$query->where('offer_is_approved', '=', 1);
		$query->where('offer_is_paid', '=', 1);

		if(!$allow_archived)
		{
			$query->where('offer_availability', '>', DB::expr('NOW()'));
			$query
				->where_open()
					->where('download_limit', '=', 0)
					->or_where_open()
						->where('download_limit', '>', 0)
						->where('download_counter', '<', DB::expr('download_limit'))
					->or_where_close()
				->where_close();
		}

		return $query;
	}

	public function add_active_conditions($allow_archived = FALSE)
	{
		return $this->query_active($this, $allow_archived);
	}

	public function filter_by_inactive()
	{
		$this->where_open();

		$this->where('offer_availability', '<=', DB::expr('NOW()'));
		$this->or_where('offer_is_approved', '!=', 1);
		$this->or_where('offer_is_paid', '!=', 1);

		$this->or_where_open()
				->where('download_limit', '>', 0)
				->where('download_counter', '>=', DB::expr('download_limit'))
			->where_close();

		return $this->where_close();
	}

	public function add_last_category()
	{
		$this->select(
					array('offer_categories.category_id', 'last_category_id'),
					array('offer_categories.category_name', 'last_category_name'))
			->join('offer_categories', 'LEFT')
					->on('offer_categories.category_id', '=', 'offer.category_id');

		return $this;
	}

	public function _apply_filters($filters)
	{
		if(empty($filters))
			return $this;

		if ( ! empty($filters['age_filter']))
		{
			$categories = new Model_Offer_Category;
			$excluded_categories = $categories->get_age_confirm_categories();

			if(!empty($excluded_categories))
			{
				$this->where(
					$this->object_name().'.category_id',
					'NOT IN',
					$excluded_categories->as_array('category_id')
				);
			}
		}

		if ( ! empty($filters['status']))
		{
			if ($filters['status'] == 'not_active')
			{
				$this->filter_by_inactive();
			}
			elseif ($filters['status'] == 'active')
			{
				$this->add_active_conditions();
			}
		}
		elseif(!isset($filters['status_choose']))
		{
			$this->add_active_conditions();
		}

		if ( ! empty($filters['closet']))
		{
			$this->join('offers_to_users', 'RIGHT')->on('offer.offer_id', '=', 'offers_to_users.offer_id');
			$this->where('offers_to_users.user_id', '=', $filters['closet']);
		}

		if ( ! empty($filters['phrase'])) {

			if ( ! empty($filters['where']))
			{
				if ($filters['where'] == 'title_and_description') {
					$this->and_where_open();
					$this->where('offer_title', 'LIKE', "%$filters[phrase]%");
					$this->or_where('offer_content', 'LIKE', "%$filters[phrase]%");
					$this->and_where_close();
				}
				elseif ($filters['where'] == 'title')
				{
					$this->where('offer_title', 'LIKE', "%$filters[phrase]%");
				}
				elseif ($filters['where'] == 'description')
				{
					$this->where('offer_content', 'LIKE', "%$filters[phrase]%");
				}
			}
			else
			{
				$this->and_where_open();
				$this->where('offer_title', 'LIKE', "%$filters[phrase]%");
				$this->or_where('offer_content', 'LIKE', "%$filters[phrase]%");
				$this->and_where_close();
			}
		}

		if ( ! empty($filters['price_from'])) 
		{
			$this->where('offer_price', '>', $filters['price_from']);
		}

		if ( ! empty($filters['price_to']))
		{
			$this->where('offer_price', '>', $filters['price_to']);
		}

		if ( ! empty($filters['from']))
		{
			if ($filters['from'] == 'company' OR $filters['from'] == 'person')
			{
				$this->where('offer_person_type', '=', $filters['from']);
			}
			elseif($filters['from'] == 'today_ending')
			{
				$this->filter_by_today_ending();
			}
		}

		if ( ! empty($filters['user_id']))
		{
			$this->where('offer.user_id', '=', $filters['user_id']);
		}

		if ( ! empty($filters['user']))
		{
			$this->filter_by_user($filters['user']);
		}

		if ( ! empty($filters['promoted']) )
		{
			$this->having('is_promoted', '=', 1);
		}

		if ( ! empty($filters['category_id']))
		{
			$this
					->join('offers_to_categories')->on('offer.offer_id', '=', 'offers_to_categories.offer_id')
					->where('offers_to_categories.category_id', '=', $filters['category_id'])
					->group_by('offer.offer_id');
		}

		if ( ! empty($filters['province_select'])) 
		{
			$this->filter_by_province($filters['province_select']);
		}
		elseif ( ! empty($filters['province']))
		{
			$this->filter_by_province($filters['province']);
		}

		if ( ! empty($filters['city'])) 
		{
			$this->filter_by_city($filters['city']);
		}

		if ( ! empty($filters['county']))
		{
			$this->filter_by_county($filters['county']);
		}

		if ( ! empty($filters['company']))
		{
			$this->filter_by_company($filters['company']);
		}
		
	}

	protected function _rebuild_category($values)
	{
		if (empty($values['category_id']))
		{
			return;
		}

		DB::delete('offers_to_categories')->where('offer_id', '=', $this->pk())->execute();

		$sub_category_id = $values['category_id'];
		$sub_category = ORM::factory('Offer_Category')->where('category_id', '=', $sub_category_id)->find();

		while ($sub_category->category_id)
		{
			$model = ORM::factory('Offer_To_Category');
			$model->offer_id = $this->pk();
			$model->category_id = $sub_category->category_id;
			$model->save();
			$sub_category = $sub_category->get_parent();
		}
	}

	public function custom_select()
	{
		$this->select(array(DB::expr('
			IF( (offer_distinction = '.self::DISTINCTION_PREMIUM.' OR offer_distinction= '.self::DISTINCTION_PREMIUM_PLUS.') AND offer_promotion_availability > NOW(), 1, 0)
		'), 'is_promoted'));

		return $this;
	}

	public function has_owner()
	{
		return $this->user_id && $this->user->loaded();
	}

	public function has_image()
	{
		return !empty($this->image_id) && !empty($this->image);
	}

	public function get_active_coupon_counter()
	{
		if(!$this->download_limit)
			return 0;

		return $this->download_limit - $this->download_counter;
	}

	public function get_coupon(Model_Coupon_Owner $coupon_owner)
	{
		$pdf = View_PDF::factory('pdf/offers/coupon')
			->set('offer', $this)
			->set('coupon_owner', $coupon_owner);
		
		$image = $this->get_first_image();
		
		if($image AND $image->exists('offer_show_big'))
 		{
			$image_path = $image->get_uri('offer_show_big');

			$pdf->add_image('coupon', DOCROOT.$image_path);
		}
		else
		{
			$pdf->add_image('coupon', Media::find_file('img', 'no_photo.jpg'));
		}

		return $pdf->render();
	}

	public function send_coupons($coupons, $notify_offer_owner = TRUE)
	{
		$email = new Model_Email();
		$email->find_by_alias('coupon_send');

		if(!$email->loaded())
		{
			throw new Kohana_Exception('Cannot find email content! (alias: :alias)', array(
				':alias' => 'coupon_send',
			));
		}

		$email->set_tags(array(
			'%offer.title%' => $this->offer_title,
			'%offer.url%' => HTML::anchor(Route::url('site_offers/frontend/offers/show', array(
				'offer_id' => $this->pk(),
				'title' => URL::title($this->offer_title),
			), 'http'), $this->offer_title),
		));
		
		$email_options = array('attachments' => array());
		$tokens = array();
		
		foreach($coupons as $index => $coupon)
		{
			$coupon_data = $this->get_coupon($coupon);
			$email_options['attachments'][] = array(
				'filename' => ___('offers.filename', array(':nb' => ($index+1))).'.pdf',
				'data' => $coupon_data,
			);
			
			$tokens[] = $coupon->token;
		}

		if($email->send($coupons[0]->email, $email_options))
		{
			$this->download_counter += count($coupons);
			$this->save();

			if($notify_offer_owner)
			{
				if(!empty($this->offer_email))
				{
					$owner_email = $this->offer_email;
				}
				elseif($this->has_company())
				{
					$owner_email = $this->catalog_company->company_email;
				}
				elseif($this->has_owner())
				{
					$owner_email = $this->user->user_email;
				}
				else
				{
					return TRUE;
				}

				$email = new Model_Email();
				$email->find_by_alias('coupon_send_confirmation');

				$email->set_tags(array(
					'%coupon_owner.email%' => $coupons[0]->email,
					'%coupon_owner.token%' => implode(', ', $tokens),
					'%offer.title%' => $this->offer_title,
					'%offer.url%' => HTML::anchor(Route::url('site_offers/frontend/offers/show', array(
						'offer_id' => $this->pk(),
						'title' => URL::title($this->offer_title),
					), 'http'), $this->offer_title),
				));

				$email->send($owner_email);
			}

			return TRUE;
		}

		return FALSE;
	}

	public function find_offers_for_notifier(Model_Notifier $notifier)
	{
		$self = new self();
		$self->add_active_conditions();
		$self->select('offer_categories.*')
			->where('offer_notifier_sent', '=', 0)
			->join('offers_to_categories', 'RIGHT')->on('offer.offer_id', '=', 'offers_to_categories.offer_id')
			->join('offer_categories', 'RIGHT')
				->on('offers_to_categories.category_id', '=', 'offer_categories.category_id')
			->where('offers_to_categories.category_id', 'IN', $notifier->get_categories())
			->group_by('offer.offer_id')
			->order_by('offers_to_categories.category_id');

		if (Kohana::$config->load('modules.site_offers.settings.provinces_enabled') AND ! empty($notifier->notify_provinces))
		{
			$self->filter_by_province($notifier->notify_provinces);
		}

		return $self->find_all();
	}

	public function mark_notified()
	{
		DB::update($this->table_name())
			->set(array('offer_notifier_sent' => TRUE))
			->where('offer_availability', '>', DB::expr('NOW()'))
			->where('offer_is_approved', '=', 1)
			->where('offer_notifier_sent', '=', 0)
			->execute();
	}
	
	public function get_query_builder($type = Database::SELECT)
	{
		foreach ($this->_db_pending as $key => $method)
		{
			if ($method['name'] == 'select')
			{
				unset($this->_db_pending[$key]);
			}
		}
		
		$this->_build($type);
		
		return $this->_db_builder;
	}

	public static function count_offers()
	{
		$self = new self();
		$self->add_active_conditions();

		return $self->count_all();
	}

	public function get_email_address()
	{
		if(!$this->offer_email)
		{
			if($this->has_owner() AND $this->user->user_email)
			{
				return $this->user->user_email;
			}
			
			if($this->has_company() AND $this->catalog_company->company_email)
			{
				return $this->catalog_company->company_email;
			}
		}
		return $this->offer_email;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		$email = $this->get_email_address();
		
		if(!$email)
		{
			Kohana::$log->add(Log::WARNING, '(site_offers) No e-mail address for offer :id', array(
				':id' => $this->pk(),
			));
			return FALSE;
		}
		
		if($subject instanceof Model_Email)
		{
			return $subject->send($email, $params);
		}
		
		return Email::send($email, $subject, $message, $params);
	}
	
	public function send_offer_approved()
	{
		$email = Model_Email::email_by_alias('offer_approved');

		$email->set_tags(array(
			'%link%'	=> HTML::anchor(Route::url('site_offers/frontend/offers/show', array(
				'offer_id' => $this->pk(), 
				'title' => URL::title($this->offer_title)
			), 'http')),
		));
		
		return $this->send_email_message($email);
	}
	
	public function send_offer_approve()
	{
		$email = Model_Email::email_by_alias('offer_approve');

		$url = Route::url('site_offers/frontend/offers/show', array(
			'offer_id' => $this->pk(), 
			'title' => URL::title($this->offer_title)
		), 'http') . '?preview=true';

		$email->set_tags(array(
			'%admin_link%'	  => ('<a href="' . $url . '">' . $url . '</a>')
		));

		$admins = ORM::factory('User')
				->with_groups(array('Administrator'))
				->find_all();

		foreach ($admins as $a)
		{
			$email->send($a->user_email);
		}
	}
	
	public static function count_by_company(Model_Catalog_Company $company)
	{
		$self = new self();
		$self->add_active_conditions();
		$self->filter_by_company($company);
		
		return $self->count_all();
	}
	
}
