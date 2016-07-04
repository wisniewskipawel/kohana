<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Model_Catalog_Company extends ORM implements IEmailMessageReceiver {
	
	const PROMOTION_TYPE_BASIC			= 0;
	const PROMOTION_TYPE_PREMIUM		= 1;
	const PROMOTION_TYPE_PREMIUM_PLUS	= 2;
	
	const ALLOWED_DESCRIPTION_TAGS = '<b><em><ul><li><ol><p><span><br><div><br>';
	const ALLOWED_PRODUCTS_TAGS = '<b><em><ul><li><ol><p><span><br><div><br>';
	
	const COMPANY_HOURS_NONE		= -1;
	const COMPANY_HOURS_CLOSED	= 0;
	const COMPANY_HOURS_OPEN	= 1;

	protected $_table_name = 'catalog_companies';
	protected $_primary_key = 'company_id';
	protected $_primary_val = 'company_name';

	protected $_has_many = array(
		'categories'		=> array('model' => 'Catalog_Category', 'through' => 'catalog_categories_to_companies', 'foreign_key' => 'company_id'),
		'tags'			  => array('model' => 'Catalog_Tag', 'foreign_key' => 'company_id'),
		'images'			=> array('model' => 'Image', 'foreign_key' => 'object_id')
	);

	protected $_belongs_to = array(
		'user'	  => array('model' => 'User', 'foreign_key' => 'user_id'),
		'first_category' => array('model' => 'Catalog_Category', 'foreign_key' => 'first_category_id'),
	);
	
	protected $_created_column = array(
		'column' => 'company_date_added',
		'format' => 'Y-m-d H:i:s',
	);
	
	protected $_updated_column = array(
		'column' => 'company_date_updated',
		'format' => 'Y-m-d H:i:s',
	);
	
	protected $_serialize_columns = array('company_hours');
	
	protected $_contact_data = NULL;

	public function add_company(Catalog_Company_Promotion_Type $type, array $values, array $images)
	{
		$this->values($values, array(
			'company_name', 'company_address', 'company_city', 'company_telephone', 'company_postal_code',
			'company_email', 'company_description', 'company_products', 'province_select', 'link', 'user_id',
			'company_county', 'company_nip', 'company_hours',
		));
		
		if($type)
		{
			$this->promotion_type = $type->get_id();
		}
		
		$this->company_is_approved = $this->promotion_type != self::PROMOTION_TYPE_BASIC;
		$this->company_promotion_availability = date('Y-m-d H:i:s', time() - 1);
		$this->company_is_promoted = FALSE;
		
		$this->slug = $this->promotion_type == self::PROMOTION_TYPE_PREMIUM_PLUS ? 
			URL::title(Arr::get($values, 'slug', Arr::get($values, 'company_name')), '_', TRUE) : NULL;
		$this->ip_address = Request::$client_ip;
		
		$this->company_map_lat = Arr::path($values, 'company_map.lat');
		$this->company_map_lng = Arr::path($values, 'company_map.lng');
		
		$this->save();
		
		if($this->saved())
		{
			if(!empty($values['photos']))
			{
				foreach($values['photos'] as $file_path)
				{
					$this->add_photo($file_path);
				}
			}
			
			if(!empty($images['logo']) && Upload::valid($images['logo']))
			{
				$this->add_logo($images['logo']);
			}

			$this->_save_categories($values, $type->get_limit('categories'));

			$tags = new Model_Catalog_Tag();
			$tags->save_for_company($this, Arr::get($values, 'company_keywords'));
		}
		
		return $this;
	}
	
	public function add_company_admin(array $values, array $files)
	{
		$types = new Catalog_Company_Promotion_Types();
		$type = $types->get_by_id(Arr::get($values, 'promotion_type'));
		
		$values['company_date_added'] = date('Y-m-d H:i:s');
		$this->values($values)->save();
		
		$this->_save_categories($values, $type->get_limit('categories'));
		
		if(!empty($values['photos']))
		{
			foreach($values['photos'] as $file_path)
			{
				$this->add_photo($file_path);
			}
		}

		if(!empty($files['logo']) && Upload::valid($files['logo']))
		{
			$this->add_logo($files['logo']);
		}
	}

	public function edit_company(array $values, array $files = array())
	{
		$this->values($values, array(
			'company_name', 'company_address', 'company_city', 'company_telephone', 'company_postal_code',
			'company_email', 'company_description', 'company_products', 'province_select', 'link',
			'company_county', 'company_nip', 'company_hours', 'slug', 'promotion_type', 'company_is_promoted',
		));
		
		$this->company_map_lat = Arr::path($values, 'company_map.lat');
		$this->company_map_lng = Arr::path($values, 'company_map.lng');
		$this->save();
		
		$this->_save_categories($values, $this->get_promotion_type_limit('categories'));
		
		$tags = new Model_Catalog_Tag();
		$tags->save_for_company($this, Arr::get($values, 'company_keywords'));
		
		if(!empty($values['photos']))
		{
			foreach($values['photos'] as $file_path)
			{
				$this->add_photo($file_path);
			}
		}

		if(!empty($files['logo']) && Upload::valid($files['logo']))
		{
			$this->add_logo($files['logo']);
		}
	}

	public function edit_company_admin(array $values, array $files = array())
	{
		$this->values($values);
		$this->company_map_lat = Arr::path($values, 'company_map.lat');
		$this->company_map_lng = Arr::path($values, 'company_map.lng');
		$this->save();
		
		$this->_save_categories($values, $this->get_promotion_type_limit('categories'));
		
		$tags = new Model_Catalog_Tag();
		$tags->save_for_company($this, Arr::get($values, 'company_keywords'));
		
		if(!empty($values['photos']))
		{
			foreach($values['photos'] as $file_path)
			{
				$this->add_photo($file_path);
			}
		}

		if(!empty($files['logo']) && Upload::valid($files['logo']))
		{
			$this->add_logo($files['logo']);
		}
	}
	
	public function save(Validation $validation = NULL)
	{
		if($this->promotion_type == self::PROMOTION_TYPE_PREMIUM_PLUS AND !$this->slug)
		{
			throw new Validation_Exception('No required slug for company Premium PLUS entry!');
		}
		
		parent::save($validation);
	}
	
	public function add_to_closet($user_id)
	{
		$is_added = ORM::factory('Catalog_CompanyToUser')
				->where('company_id', '=', $this->company_id)
				->where('user_id', '=', $user_id)
				->count_all();
		
		if ($is_added)
		{
			return;
		}
		
		$closet = ORM::factory('Catalog_CompanyToUser');
		$closet->company_id = $this->company_id;
		$closet->user_id = $user_id;
		$closet->save();
	}
	
	public function prev()
	{
		$prev = self::factory($this->_object_name)
				->add_promotion_conditions()
				->where('company_id', '<', $this->company_id)
				->order_by('company_id', 'DESC')
				->find();
		
		if ($prev->loaded())
		{
			return $prev;
		}
		
		return FALSE;
	}
	
	public function next()
	{
		$next = self::factory($this->_object_name)
				->add_promotion_conditions()
				->where('company_id', '>', $this->company_id)
				->order_by('company_id', 'ASC')
				->find();
		
		if ($next->loaded())
		{
			return $next;
		}
		
		return FALSE;
	}
	
	public function count_images()
	{
		return ORM::factory('Image')
				->where('object_type', '=', 'catalog_company')
				->where('object_id', '=', $this->pk())
				->count_all();
	}

	public function get_contact()
	{
		if(!$this->loaded())
		{
			return NULL;
		}
		
		if($this->_contact_data)
		{
			return $this->_contact_data;
		}

		$this->_contact_data = Contact::factory(Contact::TYPE_COMPANY);
		$this->_contact_data->name = $this->company_name;
		$this->_contact_data->phone = $this->company_telephone;
		$this->_contact_data->email = $this->company_email;
		$this->_contact_data->www = $this->link;
		$this->_contact_data->nip = $this->company_nip;
		
		$address = new Address();
		$address->province_id = $this->province_select;
		$address->province = catalog::province_to_text($this->province_select);
		$address->county_id = $this->company_county;
		$address->county = Regions::county($this->company_county, $this->province_select);
		$address->postal_code = $this->company_postal_code;
		$address->city = $this->company_city;
		$address->street = $this->company_address;
		
		$this->_contact_data->address = $address;
		
		return $this->_contact_data;
	}
	
	public function get_address()
	{
		return $this->get_contact() ? $this->get_contact()->address : NULL;
	}

	/**
	 * @param bool $with_logo
	 * @return ImageCollection
	 */
	public function get_images($with_logo = FALSE)
	{
		if($with_logo)
		{
			$manager = $this->get_logo_manager();
		}
		else
		{
			$manager = $this->get_gallery_manager();
		}
		
		return $manager->find_images_by_object_id($this->pk());
	}
	
	public function approve()
	{
		$this->company_is_approved = 1;
		$this->save();
	}
	
	public function filter_by_category($category)
	{
		return $this->join('catalog_categories_to_companies')
				->on('catalog_company.company_id', '=', 'catalog_categories_to_companies.company_id')
			->where('catalog_categories_to_companies.category_id', '=', (int) ($category instanceof Model_Catalog_Category ? $category->pk() : $category));
	}
	
	public function filter_by_county($county)
	{
		return $this->where('company_county', '=', (int)$county);
	}
	
	public function filter_by_province($province)
	{
		return $this->where('province_select', '=', (int)$province);
	}
	
	public function filter_by_city($city)
	{
		return $this->where('company_city', 'LIKE', $city);
	}
	
	public function only_approved()
	{
		return $this->where('company_is_approved', '=', TRUE);
	}
	
	public function search_phrase($phrase, $where = 'name_and_description')
	{
		$phrase = UTF8::trim($phrase);
		
		$this->join(array($this->tags->table_name(), 'tags'), 'LEFT')
			->on($this->object_name().'.'.$this->primary_key(), '=', 'tags.'.$this->_has_many['tags']['foreign_key'])
			->group_by('tags.company_id');
		
		if(UTF8::strlen($phrase) >= 4)
		{
			if($where == 'name')
			{
				$where = $this->_db->quote_column("company_name");
			}
			elseif($where == 'description')
			{
				$where = $this->_db->quote_column("company_description").','.
					$this->_db->quote_column("company_products");
			}
			else
			{
				$where = $this->_db->quote_column("company_name").','.
					$this->_db->quote_column("company_description").','.
					$this->_db->quote_column("company_products");
			}

			$this
				->where_open()
					->where(DB::expr('MATCH('.$where.')'), "AGAINST", DB::expr("(:phrase IN BOOLEAN MODE)"))
						->param(':phrase', $phrase)
					->or_where('tags.tag', 'LIKE', $phrase)
				->where_close();
		}
		else
		{
			$phrase = '%'.$phrase.'%';
			
			if($where == 'name')
			{
				$this->where('company_name', 'LIKE', $phrase);
			}
			elseif($where == 'description')
			{
				$this->where_open();
				$this->or_where('company_description', 'LIKE', $phrase);
				$this->or_where('company_products', 'LIKE', $phrase);
				$this->where_close();
			}
			else
			{
				$this->where_open();
				$this->where('company_name', 'LIKE', $phrase);
				$this->or_where('company_description', 'LIKE', $phrase);
				$this->or_where('company_products', 'LIKE', $phrase);
				$this->or_where('tags.tag', 'LIKE', $phrase);
				$this->where_close();
			}
		}
		
		return $this;
	}
	
	public function search(array $values, $limit, $offset) 
	{
		if (empty($values))
		{
			return array();
		}
		
		$this->add_custom_select();
		$this->apply_filters($values);
		$this->group_by('catalog_company.company_id');
		
		$this->limit($limit)->offset($offset);
		
		$this->order_by('catalog_company.company_id', 'DESC');
		
		return $this->find_all();
	}

	public function get_list_admin(array $filters, $limit, $offset)
	{
		$this->limit($limit)->offset($offset)
			->with('user')
			->order_by('catalog_company.company_id', 'DESC');
		
		$this->add_custom_select();
		$this->apply_filters($filters);
		
		return $this->find_all();
	}
	
	public function count_search($filters)
	{
		$result = $this->search($filters, 999999999, 0);
		return count($result);
	}

	public function can_prolong_promote()
	{
		$type = $this->get_promotion_type();
		return $type AND $type->is_enabled() AND !$type->is_type(self::PROMOTION_TYPE_BASIC);
	}
	
	public function filter_by_promoted($main_page = FALSE)
	{
		$this->where('company_is_promoted', '=', 1);
		$this->where('company_promotion_availability', '>', DB::expr('NOW()'));
		
		if($main_page)
		{
			$this->where(DB::expr('DATEDIFF(NOW(), company_date_added)'), '<', 30);
		}
		
		return $this;
	}
	
	public function filter_by_promotion_type($promotion_type)
	{
		return $this->where('promotion_type', is_array($promotion_type) ? 'IN' : '=', $promotion_type);
	}
	
	public function filter_by_user($user)
	{
		return $this->where($this->object_name().'.user_id', '=', (int)($user instanceof Model_User ? $user->pk() : $user));
	}
	
	public function filter_by_active()
	{
		return $this->where('company_is_approved', '=', TRUE);
	}
	
	public function with_image($required = FALSE)
	{
		$this->select('image.image_id', 'image.image')
			->join(array('images', 'image'), 'LEFT')
				->on('image.object_id', '=', 'catalog_company.company_id')
				->on('image.object_type', '=', DB::expr($this->_db->escape('catalog_company_logo')))
			->group_by('catalog_company.company_id');
		
		if($required)
		{
			$this->where('image.image_id', 'IS NOT', NULL);
		}
		
		return $this;
	}
	
	public function has_first_category()
	{
		return $this->first_category_id && $this->first_category->loaded();
	}
	
	public function has_company_hours()
	{
		if($this->get_promotion_type_limit('hours') AND $this->company_hours AND is_array($this->company_hours))
		{
			foreach($this->company_hours as $day_arr)
			{
				if(isset($day_arr['open']) AND $day_arr['open'] == self::COMPANY_HOURS_OPEN)
					return TRUE;
			}
		}
		
		return FALSE;
	}

	public function apply_filters($filters) 
	{
		if(empty($filters))
			return $this;
		
		if ( ! empty($filters['closet']))
		{
			$this->join('catalog_companies_to_users')->on('catalog_company.company_id', '=', 'catalog_companies_to_users.company_id');
			$this->where('catalog_companies_to_users.user_id', '=', $filters['closet']);
		}
		
		if ( ! empty($filters['approved']))
		{
			$this->where('company_is_approved', '=', 1);
		}
		
		if ( ! empty($filters['promoted_now']))
		{
			$this->where('company_is_promoted', '=', 1);
			$this->where('company_promotion_availability', '>', DB::expr('NOW()'));
		}
		
		if ( ! empty($filters['category']) AND $filters['category'] != 'all') 
		{
			$this->join('catalog_categories_to_companies')->on('catalog_categories_to_companies.company_id', '=', 'catalog_company.company_id');
			$this->where('category_id', '=', $filters['category']);
		}
		
		if ( ! empty($filters['promoted'])) 
		{
			if ($filters['promoted'] == 'now') 
			{
				$this->where('company_is_promoted', '=', 1);
				$this->where('company_promotion_availability', '>', DB::expr('NOW()'));
			}
			elseif ($filters['promoted'] == 'past')
			{
				$this->where('company_is_promoted', '=', 1);
				$this->where('company_promotion_availability', '<', DB::expr('NOW()'));
			}
			elseif ($filters['promoted'] == 'no')
			{
				$this->where('company_is_promoted', '=', 0);
			}
		}
		if ( ! empty($filters['user_id'])) 
		{
			$this->where('catalog_company.user_id', '=', $filters['user_id']);
		}
		
		if ( ! empty($filters['province']))
		{
			$this->where('province_select', '=', $filters['province']);
		}
		
		if ( ! empty($filters['county']))
		{
			$this->filter_by_county($filters['county']);
		}
		
		// advanced search
		
		if ( ! empty($filters['phrase']))
		{
			if (empty($filters['where']))
			{
				$this->join('catalog_tags', 'LEFT')->on('catalog_company.company_id', '=', 'catalog_tags.company_id');

				$this->and_where_open();
				$this->where('catalog_tags.tag', 'LIKE', "%$filters[phrase]%");
				$this->or_where('catalog_company.company_name', 'LIKE', "%$filters[phrase]%");
				$this->or_where('catalog_company.company_description', 'LIKE', "%$filters[phrase]%");
				$this->and_where_close();	
			}
			else
			{
				if ($filters['where'] == 'name_and_description')
				{
					$this
							->and_where_open()
							->where('catalog_company.company_name', 'LIKE', "%$filters[phrase]%")
							->or_where('catalog_company.company_description', 'LIKE', "%$filters[phrase]%")
							->and_where_close();
				}
				elseif ($filters['where'] == 'name')
				{
					$this
							->and_where_open()
							->where('catalog_company.company_name', 'LIKE', "%$filters[phrase]%")
							->and_where_close();
				}
				elseif ($filters['where'] == 'description')
				{
					$this
							->and_where_open()
							->where('catalog_company.company_description', 'LIKE', "%$filters[phrase]%")
							->and_where_close();
				}
			}
		}
		
		if ( ! empty($filters['province_select']))
		{
			$this
					->where('catalog_company.province_select', '=', $filters['province_select']);
		}
		
		if ( ! empty($filters['city']))
		{
			$this->where('catalog_company.company_city', 'LIKE', $filters['city']);
		}
		
		if ( ! empty($filters['category_id']) AND $filters['category_id'] != 'all')
		{
			$this
				->join('catalog_categories_to_companies')->on('catalog_company.company_id', '=', 'catalog_categories_to_companies.company_id')
				->where('catalog_categories_to_companies.category_id', '=', $filters['category_id']);
		}
		
		if ( ! empty($filters['company_id'])) 
		{
			$this->where($this->object_name().'.company_id', '=', (int)$filters['company_id']);
		}
		
		return $this;
	}
	
	public function get_recommended($limit) 
	{
		$this->add_custom_select();
		$this->filter_by_active();
		$this->add_promotion_conditions();
		
		$this->order_by(DB::expr('RAND()'));
		$this->limit($limit);
		
		return $this->find_all();
	}

	public function get_promoted(Model_Catalog_Category $category, $limit) 
	{
		$this->add_promotion_conditions();
		$this->add_custom_select();
		
		$this->order_by(DB::expr('RAND()'));
		$this->limit($limit);
		
		$this->join('catalog_categories_to_companies', 'RIGHT')->on('catalog_company.company_id', '=', 'catalog_categories_to_companies.company_id');
		$this->where('catalog_categories_to_companies.category_id', '=', $category->category_id);
		$this->group_by('catalog_company.company_id');
		
		return $this->find_all();
	}

	/**
	 * @param int $id
	 * @param int|null $user_id
	 * @return self
	 * @throws Kohana_Exception
	 */
	public function get_by_id($id, $user_id = NULL)
	{
		$this->where('company_id', '=', $id);
		if ($user_id !== NULL)
		{
			$this->where('user_id', '=', $user_id);
		}
		$this->add_custom_select();
		return $this->find();
	}
	
	public function count(array $filters)
	{
		$this->apply_filters($filters);
		
		$this->group_by('catalog_company.company_id');
		
		return count($this->find_all());
	}
	
	/**
	 * Count the number of records in the table.
	 *
	 * @return integer
	 */
	public function count_list_companies()
	{
		$ignored = array();
		
		foreach ($this->_db_pending as $key => $method)
		{
			if ($method['name'] == 'select' || $method['name'] == 'group_by')
			{
				$ignored[] = $method;
				unset($this->_db_pending[$key]);
			}
		}

		if ( ! empty($this->_load_with))
		{
			foreach ($this->_load_with as $alias)
			{
				// Bind relationship
				$this->with($alias);
			}
		}

		$this->_build(Database::SELECT);

		$records = $this->_db_builder->from(array($this->_table_name, $this->_object_name))
			->select(array(DB::expr('COUNT(DISTINCT '.$this->_db->quote_column($this->object_name().'.'.$this->primary_key()).')'), 'records_found'))
			->execute($this->_db)
			->get('records_found');

		// Add back in selected columns
		$this->_db_pending += $ignored;

		$this->reset();

		// Return the total number of records in a table
		return $records;
	}

	public function get_list($filters, $offset, $limit)
	{
		$this->apply_filters($filters);
		
		$this->add_custom_select();
		
		$this->offset($offset);
		$this->limit($limit);
		
		$this->order_by('company_is_promoted_now', 'DESC');
		$this->order_by('company_date_added', 'DESC');
		
		$this->group_by('catalog_company.company_id');
		
		return $this->find_all();
	}
	
	public function order_list()
	{
		$this->order_by('company_is_promoted_now', 'DESC');
		$this->order_by('company_date_added', 'DESC');
		
		$this->group_by('catalog_company.company_id');
		
		return $this;
	}

	/**
	 * @return ImageManager
	 */
	public function get_gallery_manager()
	{
		return new ImageManager('catalog_company', 'catalog', 'catalog_companies');
	}

	/**
	 * @return ImageManager
	 */
	public function get_logo_manager()
	{
		return new ImageManager('catalog_company_logo', 'catalog', 'catalog_companies');
	}

	/**
	 * @param $path
	 * @return bool
	 */
	public function add_photo($path)
	{
		return $this->get_gallery_manager()->save_image($path, $this->pk());
	}

	/**
	 * @param $file
	 * @return bool
	 * @throws Kohana_Exception
	 */
	public function add_logo($file)
	{
		$logo = $this->get_logo();
		
		if($logo)
		{
			$logo->delete();
		}

		$path = Upload::save($file);
		return $this->get_logo_manager()->save_image($path, $this->pk());
	}
	
	public function promote($type_id = NULL)
	{
		$type_id = $type_id !== NULL ? $type_id : $this->promotion_type;
		$types = new Catalog_Company_Promotion_Types();
		$type = $types->get_by_id($type_id);
		
		if(!$type AND $type->is_enabled())
			throw new Kohana_Exception('Wrong promotion type!');
		
		$this->promotion_type = $type->get_id();
		$this->company_is_promoted = 1;
		$date = strtotime($this->company_promotion_availability);
		
		if($date === FALSE OR $date < time())
		{
			$date = time();
		}
		
		$date_span = $type->get_limit('date_span');
		$this->company_promotion_availability = date('Y-m-d H:i:s', $date + $date_span);
		
		$this->save();
	}

	/**
	 * @return Catalog_Company_Promotion_Type|null
	 */
	public function get_promotion_type()
	{
		if(!$this->promotion_type)
			return NULL;

		$types = new Catalog_Company_Promotion_Types();
		return $types->get_by_id($this->promotion_type);
	}

	/**
	 * @param $name
	 * @return mixed|null
	 */
	public function get_promotion_type_limit($name)
	{
		$type = $this->get_promotion_type();
		return $type ? $type->get_limit($name) : NULL;
	}
	
	public function get_promotion_days_left()
	{
		if(!$this->is_promoted())
			return NULL;
		
		return ceil((strtotime($this->company_promotion_availability) - time()) / Date::DAY);
	}
	
	protected function _save_categories(array $values, $limit = 1)
	{
		if(!isset($values['category']))
			return FALSE;
		
		DB::delete('catalog_categories_to_companies')
			->where('company_id', '=', $this->pk())
			->execute();
		
		$relation_nb = 0;
		
		foreach($values['category'] as $category)
		{
			if($limit <= 0)
				return;
			
			if(empty($category))
				continue;
			
			$category = ORM::factory('Catalog_Category')->find_by_pk($category);
			
			if(!$category->loaded())
				continue;

			$category_data = array(
				'category_id' => (int)$category->pk(),
				'company_id' => (int)$this->pk(),
				'relation_nb' => (int)$relation_nb,
			);
			
			ORM::factory('Catalog_CategoryToCompany')->values($category_data)->save();

			//save first category
			if($relation_nb == 0)
			{
				$this->first_category_id = (int)$category->pk();
				$this->save();
			}
			
			$parents = $category->get_parents();
			
			foreach ($parents as $parent) 
			{
				$category_data['category_id'] = $parent->pk();
				
				ORM::factory('Catalog_CategoryToCompany')
					->values($category_data)
					->save();
			}
			
			$relation_nb++;
			$limit--;
		}
		
		return $relation_nb;
	}

	public function get_from_user($user_id, $limit, $offset) 
	{
		$this->add_custom_select();
		$this->where('user_id', '=', $user_id);
		$this->order_by('company_id', 'DESC');

		$this->limit($limit)->offset($offset);
		
		return $this->find_all();
	}

	public function get_for_select_from_user(Model_User $user) 
	{
		return $this
			->get_from_user($user->pk(), 999999, 0)
			->as_array('company_id', 'company_name');
	}
	
	public function get_rss()
	{
		$this->add_custom_select();
		$this->filter_by_promoted()
			->filter_by_active();
		
		$this->limit(50);
		$this->order_by('catalog_company.company_date_added', 'DESC');
		
		return $this->find_all();
	}

	public function is_promoted($type = NULL) 
	{
		if ($this->company_is_promoted && strtotime($this->company_promotion_availability) > time()) 
		{
			return $type !== NULL ? $this->promotion_type == $type : TRUE;
		}

		return FALSE;
	}
	
	public function is_owner(Model_User $user)
	{
		return $this->user_id AND $this->user_id == $user->pk();
	}

	/**
	 * @return ImageObject
	 */
	public function get_logo()
	{
		$images = $this->get_logo_manager()->find_images_by_object_id($this->pk());
		return count($images) ? $images->first() : NULL;
	}
	
	public function get_tags_as_string() {
		$tags = $this->tags->order_by('tag', 'ASC')->find_all();
		$array = array();

		foreach ($tags as $t) {
			$array[] = $t->tag;
		}

		return implode(', ', $array);
	}
	
	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}
		
		$companies = DB::select('company_id')
			->from('catalog_categories_to_companies')
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->group_by('company_id')
			->execute($this->_db)
			->as_array(NULL, 'company_id');
		
		$this->delete_companies($companies);
	}
	
	public function delete_companies($companies)
	{
		if(empty($companies))
		{
			return;
		}
		
		Events::fire('catalog/delete_companies', array('companies' => $companies));
		
		$reviews = new Model_Catalog_Company_Review;
		$reviews->delete_by_company($companies);
		
		$categories = new Model_Catalog_CategoryToCompany;
		$categories->delete_by_company($companies);
		
		$closet = new Model_Catalog_CompanyToUser;
		$closet->delete_by_company($companies);
		
		$tags = new Model_Catalog_Tag();
		$tags->delete_by_company($companies);

		$this->get_logo_manager()->delete_by_object($companies);
		$this->get_gallery_manager()->delete_by_object($companies);
		
		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $companies)
			->execute($this->_db);
	}

	public function  delete()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));
		
		$this->delete_companies(array($this->pk()));
		$this->clear();
		
		return $this;
	}
	
	public function add_promotion_conditions() 
	{
		$this->where('company_promotion_availability', '>', DB::expr('NOW()'));
		$this->and_where('company_is_promoted', '=', 1);
		return $this;
	}
	
	public function add_custom_select() 
	{
		$this->select(array(DB::expr('
			IF(catalog_company.company_promotion_availability > NOW(), catalog_company.promotion_type, 0)
		'), 'company_is_promoted_now'));

		//logo
		$this
			->select('image.image_id', 'image.image')
			->join(array('images', 'image'), 'LEFT')
				->on('image.object_id', '=', 'catalog_company.company_id')
				->on('image.object_type', '=', DB::expr($this->_db->escape('catalog_company_logo')))
			//->order_by('image.image_id', 'ASC')
			->group_by('catalog_company.company_id');
		
		$this->with('first_category');
	
		return $this;
	}
	
	public function province_to_text() 
	{
		return catalog::province_to_text($this->province_select);
	}
	
	public function find_by_slug($slug)
	{
		return $this->where($this->object_name().'.slug', '=', $slug)
			->find();
	}
	
	public function get_categories($last_only = FALSE)
	{
		$return = array();
		$categories_limit = $this->get_promotion_type_limit('categories');
		
		for($i = 0; $i < $categories_limit; $i++)
		{
			if($last_only)
			{
				$return[$i] = $this->categories
					->order_by('catalog_category.category_level', 'DESC')
					->where('relation_nb', '=', $i)
					->find();
			}
			else
			{
				$return[$i] = $this->categories
					->order_by('catalog_category.category_level', 'ASC')
					->where('relation_nb', '=', $i)
					->find_all()
					->as_array();
			}
		}
		
		return $return;
	}
	
	public function with_reviews()
	{
		$this->select('reviews.*');

		$model_review = new Model_Catalog_Company_Review;

		$this->join(array($model_review->company_reviews_query(), 'reviews'), 'LEFT')
			->on('reviews.r_company_id', '=', $this->object_name().'.'.$this->primary_key());

		return $this;
	}

	public static function count_companies()
	{
		$self = new self();
		$self->filter_by_active();
		
		return $self->count_all();
	}

	public function get_email_address()
	{
		return $this->company_email;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}
		
		return Email::send($this->get_email_address(), $subject, $message, $params);
	}
	
	public function has_main_category()
	{
		return $this->first_category_id AND $this->first_category->loaded();
	}
	
	public function get_main_category()
	{
		return $this->first_category;
	}

	public function __get($column)
	{
		if ($column == 'company_hours' AND array_key_exists($column, $this->_object))
		{
			return json_decode($this->_object[$column], TRUE);
		}
		
		return parent::__get($column);
	}

}
