<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Model_Product extends ORM implements IEmailMessageReceiver {

	use Trait_ImageModel;

	const DISTINCTION_NONE = 0;
	const DISTINCTION_PREMIUM = 1;
	
	const PRODUCT_STATE_NEW = 1;
	const PRODUCT_STATE_USED = 2;

	protected $_table_name = 'products';
	protected $_primary_key = 'product_id';

	protected $_belongs_to = array(
		//'main_category'	 => array('model' => 'products_Categories', 'foreign_key' => 'main_category_id'),
		'last_category'	  => array('model' => 'product_Category', 'foreign_key' => 'category_id'),
		'user'			  => array('model' => 'User', 'foreign_key' => 'user_id'),
		'user_closet'	   => array('model' => 'User', 'through' => 'products_To_Users', 'foreign_key' => 'user_id'),
		'catalog_company'   => array('model' => 'Catalog_Company', 'foreign_key' => 'company_id')
	);

	protected $_has_many = array(
		'images'		=> array('model' => 'Image', 'foreign_key' => 'object_id'),
		'categories'	=> array('model' => 'product_Category', 'through' => 'products_to_categories', 'foreign_key' => 'product_id'),
		'tags'			=> array('model' => 'Product_Tag', 'foreign_key' => 'product_id'),
	);

	protected $_created_column = array(
		'column' => 'product_date_added',
		'format' => 'Y-m-d H:i:s',
	);

	protected $_updated_column = array(
		'column' => 'product_date_updated',
		'format' => 'Y-m-d H:i:s',
	);
	
	protected $_contact_data = NULL;
	
	public function has_company()
	{
		return Modules::enabled('site_catalog') AND $this->company_id AND $this->catalog_company->loaded();
	}

	public function has_category()
	{
		return $this->category_id && $this->last_category->loaded();
	}
	
	public function has_user()
	{
		return $this->user_id AND $this->user->loaded();
	}

	public function get_last_category()
	{
		return $this->last_category;
	}

	public function search_phrase($phrase, $where = 'title_and_description')
	{
		$phrase = UTF8::trim($phrase);

		if(UTF8::strlen($phrase) >= 4)
		{
			if($where == 'title')
			{
				$where = $this->_db->quote_column('product_title');
			}
			elseif($where == 'description')
			{
				$where = $this->_db->quote_column("product_content");
			}
			else
			{
				$where = $this->_db->quote_column("product_title").','.$this->_db->quote_column("product_content");
			}
			
			$where .= ','.$this->_db->quote_column("product_manufacturer");

			$this->where(DB::expr('MATCH('.$where.')'), "AGAINST", DB::expr("(:phrase IN BOOLEAN MODE)"))
				->param(':phrase', $phrase);
		}
		else
		{
			$phrase = '%'.$phrase.'%';

			if($where == 'title')
			{
				$this->where('product_title', 'LIKE', $phrase);
			}
			elseif($where == 'description')
			{
				$this->where('product_content', 'LIKE', $phrase);
			}
			else
			{
				$this->where_open();
				$this->where('product_title', 'LIKE', $phrase);
				$this->or_where('product_content', 'LIKE', $phrase);
				$this->or_where('product_manufacturer', 'LIKE', $phrase);
				$this->where_close();
			}

		}

		return $this;
	}

	public function filter_by_category($category, $main_category = FALSE)
	{
		if($category instanceof Model_product_Category)
		{
			$category = $category->pk();
		}
		
		if($main_category)
		{
			return $this->where($this->object_name().'.category_id', is_array($category) ? 'IN' : '=', $category);
		}
		else
		{
			$this->join('products_to_categories')->on($this->object_name().'.product_id', '=', 'products_to_categories.product_id')
				->where('products_to_categories.category_id', is_array($category) ? 'IN' : '=', $category)
				->group_by($this->object_name().'.product_id');
		}
		
		return $this;
	}

	public function filter_by_prices($price_from = NULL, $price_to = NULL)
	{
		if (!empty($price_from))
		{
			$this->where('product_price', '>', $price_from);
		}

		if (!empty($price_to))
		{
			$this->where('product_price', '<', $price_to);
		}

		return $this;
	}

	public function filter_by_province($province)
	{
		$province = (int)$province;
		
		$this->with('catalog_company');
		
		$this->where_open();
		
		$this->where($this->object_name().'.product_province', '=', $province);
		$this->or_where('catalog_company.province_select', '=', $province);
		
		return $this->where_close();
	}

	public function filter_by_county($county)
	{
		$county = (int)$county;
		
		$this->with('catalog_company');
		
		$this->where_open();
		
		$this->where($this->object_name().'.product_county', '=', $county);
		$this->or_where('catalog_company.company_county', '=', $county);
		
		return $this->where_close();
	}

	public function filter_by_city($city)
	{
		$this->with('catalog_company');
		
		$this->where_open();
		
		$this->where($this->object_name().'.product_city', 'LIKE', $city);
		$this->or_where('catalog_company.company_city', 'LIKE', $city);
		
		return $this->where_close();
	}
	
	public function filter_by_company(Model_Catalog_Company $company)
	{
		return $this->where($this->object_name().'.company_id', '=', (int)$company->pk());
	}
	
	public function filter_by_user($user)
	{
		return $this->where($this->object_name().'.user_id', '=', (int)($user instanceof Model_User ? $user->pk() : $user));
	}
	
	public function filter_by_tag(Model_Product_Tag $tag)
	{
		$this->join('product_to_tag')
			->on('product_to_tag.product_id', '=', $this->object_name().'.'.$this->primary_key());
		
		return $this->where('product_to_tag.tag_id', '=', (int)$tag->pk());
	}
	
	public function filter_by_promoted($promotion_type = NULL)
	{
		if($promotion_type)
		{
			$this->where($this->object_name().'.product_distinction', '=', (int)$promotion_type);
		}
		else
		{
			$this->where($this->object_name().'.product_distinction', '>', 0);
		}
		
		return $this->where($this->object_name().'.product_promotion_availability', '>', DB::expr('NOW()'));
	}
	
	public function filter_by_manufacturer($manufacturer)
	{
		return $this->where($this->object_name().'.product_manufacturer', 'LIKE', '%'.$manufacturer.'%');
	}
	
	public function filter_by_state($state)
	{
		return $this->where($this->object_name().'.product_state', '=', (int)$state);
	}
	
	public function filter_by_expiring($days_to_expire = 2)
	{
		return $this->where(DB::expr('DATEDIFF('.$this->object_name().'.product_availability, NOW())'), '=', (int)$days_to_expire);
	}
	
	public function filter_by_type($type)
	{
		return $this->where($this->object_name().'.product_type', '=', (int)$type);
	}
	
	public function get_availability_days_left()
	{
		return ceil((strtotime($this->product_availability) - time()) / Date::DAY);
	}
	
	public function can_renew()
	{
		return $this->get_availability_days_left() <= 10;
	}

	public function renew($availability) 
	{
		$this->product_availability = $this->_calculate_availability($availability, strtotime($this->product_availability));
		$this->product_visits = 0;
		$this->save();
	}

	public function renew_admin($date) 
	{
		$this->product_availability = $date;
		$this->product_visits = 0;
		$this->save();
	}

	/**
	 * @param $values
	 * @return $this
	 * @throws Kohana_Exception
	 */
	public function add_product($values)
	{
		if ( ! empty($values['product_availability']) AND is_numeric($values['product_availability']))
		{
			$availability = $values['product_availability'];

			$this->product_availability = $this->_calculate_availability($availability);
			unset($values['product_availability']);
		}
		
		if(isset($values['product_map']))
		{
			$values['product_map_lat'] = Arr::get($values['product_map'], 'lat');
			$values['product_map_lng'] = Arr::get($values['product_map'], 'lng');
		}
		
		$this->values($values);
		$this->ip_address = Request::$client_ip;

		$this->save();

		if($this->saved())
		{
			if(!empty($values['product_tags']))
			{
				$model_tag = new Model_Product_Tag;
				$model_tag->save_tags($this, Arr::get($values, 'product_tags'));
			}
			
			$this->_rebuild_category($values);

			if(!empty($values['images']))
			{
				$this->save_images($values['images']);
			}

			if (empty($values['product_is_approved']) AND Kohana::$config->load('modules.site_products.confirmation_email'))
			{
				$email = ORM::factory('Email', array('email_alias' => 'product_approve'));

				$url = products::uri($this, 'http') . '?preview=true';

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
		}

		return $this;
	}

	public function edit_product(array $values)
	{
		if(isset($values['product_map']))
		{
			$values['product_map_lat'] = Arr::get($values['product_map'], 'lat');
			$values['product_map_lng'] = Arr::get($values['product_map'], 'lng');
		}
		
		if (array_key_exists('product_is_approved', $values) AND $values['product_is_approved'] != $this->product_is_approved AND $values['product_is_approved'])
		{
			$this->approve();
		}
		$this->values($values)->save();
		$this->_rebuild_category($values);
		
		if(isset($values['product_tags']))
		{
			$model_tag = new Model_Product_Tag;
			$model_tag->save_tags($this, Arr::get($values, 'product_tags'));
		}
	}

	public function add_to_closet(Model_User $user) 
	{
		$closet = new Model_Product_To_User;
		return $closet->save_user_product($this, $user);
	}
	
	public function is_approved()
	{
		return $this->product_is_approved;
	}

	public function approve()
	{
		$this->product_is_approved = 1;
		$this->save();

		$email = ORM::factory('Email')
				->where('email_alias', '=', 'product_approved')
				->find();

		$url = products::uri($this, 'http');

		$email->set_tags(array(
			'%link%'	=> ('<a href="' . $url . '">' . $url . '</a>'),
		));

		if ($this->user->user_id)
		{
			$email->send($this->user->user_email);
		}
		else
		{
			$email->send($this->product_email);
		}
	}

	/**
	 * @param $images
	 * @return bool
	 */
	public function save_images($images)
	{
		foreach($images as $image_path)
		{
			$this->get_image_manager()->save_image($image_path, $this->pk());
		}

		return TRUE;
	}

	public function get_promoted($limit) 
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->order_by(DB::expr('RAND()'));

		$this->add_image_to_list();

		$this->custom_select();
		$this->filter_by_promoted();

		return $this->find_all();
	}


	public function get_last($limit)
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->order_by('product_date_added', 'DESC');

		$this->add_image_to_list();
		$this->custom_select();

		return $this->find_all();
	}

	public function get_popular($limit) 
	{
		$this->limit($limit);

		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);

		$this->order_by('product_visits', 'DESC');

		$this->add_image_to_list();
		$this->custom_select();

		return $this->find_all();
	}

	public function get_recommended($limit) 
	{
		$filters['age_filter'] = TRUE;
		$this->_apply_filters($filters);
		
		$this->add_image_to_list();
		$this->limit($limit);
		return $this->find_all();
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
			$this->_contact_data = Contact::factory($this->product_person_type);
			$this->_contact_data->name = $this->product_person;
			$this->_contact_data->phone = $this->product_telephone;
			$this->_contact_data->email = $this->get_email_address();
			$this->_contact_data->www = $this->product_www;

			$address = new Address();
			$address->province_id = $this->product_province;
			$address->province = Products::province_to_text($this->product_province);
			$address->county_id = $this->product_county;
			$address->county = Regions::county($this->product_county, $this->product_province);
			$address->postal_code = $this->product_postal_code;
			$address->city = $this->product_city;
			$address->street = $this->product_street;

			$this->_contact_data->address = $address;
		}
		
		return $this->_contact_data;
	}

	public function search_advanced($data, $limit, $offset)
	{
		if (empty($data['phrase']) AND empty($data['price_from']) AND empty($data['price_to']) AND empty($data['category']) AND empty($data['city']) AND empty($data['product_province']))
		{
			return FALSE;
		}

		$this->order_by('product_date_added', 'DESC');

		$this->add_active_conditions();
		$this->add_image_to_list();
		$this->custom_select();

		$this->add_image_to_list();
		$this->with('sub_category');

		$this->limit($limit)->offset($offset);

		return $this->find_all();
	}

	public function  get_all($offset, $limit, array $filters) 
	{
		$this->add_image_to_list();
		$this->custom_select();
		
		$this->apply_ordering(TRUE);
		
		$this->_apply_filters($filters);
		
		if(!empty($filters['sort_by']))
		{
			$this->apply_ordering(Arr::get($filters, 'sort_by'), Arr::get($filters, 'sort_direction'));
		}
		else
		{
			$this->apply_ordering(FALSE);
		}
		
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

		$this->add_image_to_list();
		$this->custom_select();
		
		$this->apply_ordering(TRUE);
		
		$this->_apply_filters($filters);
		
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

	public function count_all_list(array $filters)
	{
		$this->_apply_filters($filters);
		
		$this->custom_select();
		return count($this->find_all());
	}

	public function get_by_id($id, $preview = FALSE)
	{
		$this->where('product_id', '=', $id);
		if ( ! $preview)
		{
			$this->add_active_conditions();
		}
		$this->custom_select();
		$this->group_by('product_id');

		return $this->find();
	}

	public function get_user_product($product_id, $user_id) 
	{
		$this->custom_select();
		$this->where('product_id', '=', $product_id);
		$this->where('user_id', '=', $user_id);
		return $this->find();
	}

	public function inc_visits()
	{
		$this->product_visits = $this->product_visits + 1;
		$this->save();
	}

	public function is_promoted()
	{
		return (bool) $this->is_promoted;
	}
	
	public function promote(array $values)
	{
		$days = (int) Kohana::$config->load('modules.site_products.promotion_time');

		$promotion_availability_timestamp = time() + (60 * 60 * 24 * $days);
		
		$this->product_distinction = $values['product_distinction'];
		$this->product_promotion_availability = date('Y-m-d H:i:s', $promotion_availability_timestamp);

		//make sure product will be available
		
		$availability_timestamp = intval(strtotime($this->product_availability));

		if ($promotion_availability_timestamp > $availability_timestamp)
		{
			$this->product_availability = date('Y-m-d H:i:s', $promotion_availability_timestamp);
		}

		$this->product_is_approved = TRUE;

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
		$this->order_by('product_id', 'DESC');
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
					$this->where('product_distinction', '=', self::DISTINCTION_NONE);
					break;

				case 'promoted':
					$this->filter_by_promoted();
					break;

				case 'not_active':
					$this->where('product_availability', '<', DB::expr('NOW()'));
					break;

				case 'active':
					$this->where('product_availability', '>', DB::expr('NOW()'));
					$this->where('product_is_approved', '=', 1);
					break;

				case 'not_approved':
					$this->where('product_is_approved', '=', 0);
					break;

				default:
					throw new Exception('check api!');
					break;
			}
		}
		
		if ( ! empty($filters['user_id']))
		{
			$this->where('product.user_id', '=', $filters['user_id']);
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
		
		$products = DB::select('product_id')
			->from('products_to_categories')
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->group_by('product_id')
			->execute($this->_db)
			->as_array(NULL, 'product_id');
		
		$this->delete_products($products);
	}
	
	public function delete_products($products)
	{
		if(empty($products))
		{
			return;
		}
		
		$categories = new Model_product_To_Category;
		$categories->delete_by_product($products);
		
		$closet = new Model_product_To_User();
		$closet->delete_by_product($products);
		
		$this->get_image_manager()->delete_by_object($products);
		
		$tags = new Model_Product_Tag;
		$tags->delete_by_product($products);
		
		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $products)
			->execute();
	}

	public function delete()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));
		
		$this->delete_products(array($this->pk()));
		
		$this->clear();
		
		return $this;
	}

	public function add_image_to_list($required = FALSE)
	{
		$this
			->select(array(
				DB::expr('GROUP_CONCAT(`image`.image_id ORDER BY image.`image_id` ASC )'),
				'image_ids'
			))
			->select(array(
				DB::expr('GROUP_CONCAT(`image`.image ORDER BY image.`image_id` ASC )'),
				'images'
			))
			->join(array('images', 'image'), 'LEFT')
			->on('image.object_type', '=', DB::expr($this->_db->quote('products')))
			->on('image.object_id', '=', $this->object_name().'.'.$this->primary_key())
			->group_by($this->object_name().'.'.$this->primary_key());
		
		if($required)
		{
			$this->having('image_ids', 'IS NOT', NULL);
		}
		
		return $this;
	}
	
	public function query_active($query, $allow_archived = FALSE)
	{
		if(!$allow_archived)
		{
			$query->where('product_availability', '>', DB::expr('NOW()'));
		}
		
		$query->where('product_is_approved', '=', 1);
		$query->where('product_state', '!=', 0);
		return $query;
	}

	public function add_active_conditions($allow_archived = FALSE)
	{
		return $this->query_active($this, $allow_archived);
	}

	protected function _calculate_availability($days, $now = FALSE)
	{
		if ($now === FALSE) 
		{
			$now = time();
		}
		$availability = $now + ($days * 60 * 60 * 24);
		return date('Y-m-d H:i:s', $availability);
	}

	public function add_last_category()
	{
		$this->select(
				array('product_categories.category_id', 'last_category_id'),
				array('product_categories.category_name', 'last_category_name'))
			->join('product_categories', 'LEFT')
				->on('product_categories.category_id', '=', 'product.category_id');

		return $this;
	}

	public function _apply_filters($filters)
	{
		if (empty($filters['my']))
		{
			$this->add_active_conditions();
		}

		if ( ! empty($filters['status']))
		{
			if ($filters['status'] == 'not_active')
			{
				$this->and_where_open();
				$this->where('product_availability', '<', DB::expr('NOW()'));
				$this->or_where('product_is_approved', '=', 0);
				$this->and_where_close();
			}
			elseif ($filters['status'] == 'active')
			{
				$this->add_active_conditions();
			}
		}

		if ( ! empty($filters['closet']))
		{
			$this->join('products_to_users', 'RIGHT')->on('product.product_id', '=', 'products_to_users.product_id');
			$this->where('products_to_users.user_id', '=', $filters['closet']);
		}

		if ( ! empty($filters['phrase'])) 
		{
			if ( ! empty($filters['where']))
			{
				if ($filters['where'] == 'title_and_description') 
				{
					$this->and_where_open();
					$this->where('product_title', 'LIKE', "%$filters[phrase]%");
					$this->or_where('product_content', 'LIKE', "%$filters[phrase]%");
					$this->and_where_close();
				}
				elseif ($filters['where'] == 'title')
				{
					$this->where('product_title', 'LIKE', "%$filters[phrase]%");
				}
				elseif ($filters['where'] == 'description')
				{
					$this->where('product_content', 'LIKE', "%$filters[phrase]%");
				}
			}
			else
			{
				$this->and_where_open();
				$this->where('product_title', 'LIKE', "%$filters[phrase]%");
				$this->or_where('product_content', 'LIKE', "%$filters[phrase]%");
				$this->and_where_close();
			}
		}

		if ( ! empty($filters['price_from'])) 
		{
			$this->where('product_price', '>', $filters['price_from']);
		}

		if ( ! empty($filters['price_to'])) 
		{
			$this->where('product_price', '>', $filters['price_to']);
		}

		if ( ! empty($filters['category'])) 
		{
			$this->where('main_category_id', '=', $filters['category']);
		}

		if ( ! empty($filters['from']))
		{
			if ($filters['from'] == 'company' OR $filters['from'] == 'person')
			{
				$this->where('product_person_type', '=', $filters['from']);
			}
		}

		if ( ! empty($filters['user_id']))
		{
			$this->filter_by_user($filters['user_id']);
		}

		if ( ! empty($filters['promoted']) )
		{
			$this->having('is_promoted', '=', 1);
		}

		if ( ! empty($filters['category_id']))
		{
			$this->join('products_to_categories')->on('product.product_id', '=', 'products_to_categories.product_id')
				->where('products_to_categories.category_id', '=', $filters['category_id'])
				->group_by('product.product_id');
		}

		if ( ! empty($filters['type']))
		{
			$this->filter_by_type($filters['type']);
		}

		if ( ! empty($filters['product_province']))
		{
			$this->filter_by_province($filters['product_province']);
		}
		elseif ( ! empty($filters['province']))
		{
			$this->filter_by_province($filters['province']);
		}

		if ( ! empty($filters['county']))
		{
			$this->filter_by_county($filters['county']);
		}

		if ( ! empty($filters['city'])) 
		{
			$this->filter_by_city($filters['city']);
		}

		if ( ! empty($filters['company']))
		{
			$this->filter_by_company($filters['company']);
		}

		if ( ! empty($filters['tag']))
		{
			$this->filter_by_tag($filters['tag']);
		}

		if(!empty($filters['manufacturer']))
		{
			$this->filter_by_manufacturer($filters['manufacturer']);
		}

		if(!empty($filters['state']))
		{
			$this->filter_by_state($filters['state']);
		}
	}
	
	public function apply_ordering($column = NULL, $direction = NULL)
	{
		if($column === TRUE)
		{
			$direction = strtolower($direction) == 'asc' ? 'ASC' : 'DESC';
			
			$this->order_by('is_promoted', $direction);
			
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
				$this->order_by('product_date_added', $direction);
				break;
			
			case 'price':
				$this->order_by('product_price', $direction);
				break;
			
			case 'closet':
				$this->order_by('products_to_users.product_to_user_id', $direction);
				break;
			
			case 'id':
				$this->order_by($this->object_name().'.'.$this->primary_key(), $direction);
				break;
		}
	}

	protected function _rebuild_category($values)
	{
		if (empty($values['category_id']))
		{
			return;
		}

		$products_to_categories = new Model_Product_To_Category;
		$products_to_categories->delete_by_product($this->pk());

		$category = new Model_Product_Category();
		$category->find_by_pk($values['category_id']);
		
		if($category->loaded())
		{
			$categories = $category->get_parents(TRUE, TRUE);
			
			foreach($categories as $category)
			{
				$products_to_categories->clear();
				
				$products_to_categories->product_id = $this->pk();
				$products_to_categories->category_id = $category->pk();
				$products_to_categories->save();
			}
		}
	}

	public function custom_select()
	{
		$this->select(array(DB::expr('
			IF( (product_distinction = '.self::DISTINCTION_PREMIUM.') AND product_promotion_availability > NOW(), 1, 0)
		'), 'is_promoted'));
		
		$this->with('last_category');

		return $this;
	}

	public function get_rss()
	{
		$this->add_active_conditions();
		$this->add_image_to_list();
		$this->custom_select();
		$this->limit(50);
		$this->order_by($this->object_name().'.product_date_added', 'DESC');

		return $this->find_all();
	}

	public function find_products_for_notifier(Model_Notifier $notifier)
	{
		$product = new Model_product();
		$product->add_active_conditions();
		$product->select('product_categories.*')
			->where('product_notifier_sent', '=', 0)
			->join('products_to_categories', 'RIGHT')->on('product.product_id', '=', 'products_to_categories.product_id')
			->join('product_categories', 'RIGHT')
				->on('products_to_categories.category_id', '=', 'product_categories.category_id')
			->where('products_to_categories.category_id', 'IN', $notifier->get_categories())
			->group_by('product.product_id')
			->order_by('products_to_categories.category_id');

		if (Kohana::$config->load('modules.site_products.provinces_enabled') AND ! empty($notifier->notify_provinces))
		{
			$product->filter_by_province($notifier->notify_provinces);
		}

		return $product->find_all();
	}
	
	public function find_similar(Model_Product $product, $limit)
	{
		if($product->loaded() AND $product->has_category())
		{
			$this->filter_by_category($product->get_last_category());
			$this->where($this->object_name().'.'.$this->primary_key(), '!=', (int)$product->pk());
			
			return $this->get_recommended($limit);
		}
		
		return NULL;
	}

	public function mark_notified()
	{
		DB::update($this->table_name())
			->set(array('product_notifier_sent' => TRUE))
			->where('product_availability', '>', DB::expr('NOW()'))
			->where('product_is_approved', '=', 1)
			->where('product_notifier_sent', '=', 0)
			->execute();
	}

	public static function count_products()
	{
		$self = new self();
		$self->add_active_conditions();

		return $self->count_all();
	}

	public function get_email_address()
	{
		if($this->product_email)
			return $this->product_email;
		
		if($this->has_company())
			return $this->catalog_company->company_email;
		
		if($this->has_user())
			return $this->user->user_email;
			
		return NULL;
	}
	
	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}
		
		return Email::send($this->get_email_address(), $subject, $message, $params);
	}
	
	public static function count_by_company(Model_Catalog_Company $company)
	{
		$self = new self();
		$self->add_active_conditions();
		$self->filter_by_company($company);
		
		return $self->count_all();
	}
	
	public static function check_promotion_limit($object)
	{
		if($object instanceof Model_Product)
		{
			if(!$object->has_company() OR $object->product_distinction)
				return FALSE;
			
			$company = $object->catalog_company;
		}
		else
		{
			$company = $object;
		}
		
		if(!$company->is_promoted())
			return FALSE;
		
		$product = new self;
		$product->filter_by_company($company);
		$product->filter_by_promoted();
		$count_promoted = $product->count_all();
		
		return Products::promotion_limits($company->promotion_type) > $count_promoted;
	}

	/**
	 * @return ImageManager
	 */
	public function get_image_manager()
	{
		return new ImageManager('products');
	}
}
