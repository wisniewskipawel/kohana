<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Model_Ad extends ORM {

	protected $_table_name = 'ads';
	protected $_primary_key = 'ad_id';
	protected $_primary_val = 'ad_id';
	
	protected $_belongs_to = array(
		'user'  => array('model' => 'User', 'foreign_key' => 'user_id')
	);

	const BANNER_A	  = 1;
	const BANNER_AB	 = 2;
	const BANNER_AC	 = 3;
	const BANNER_F	 = 4;
	const BANNER_B	 = 5;
	const BANNER_BB	 = 6;
	const SKYCRAPER_D   = 7;
	const BANNER_E	  = 8;
	const TEXT_C		= 10;
	const TEXT_C1	   = 11;
	const BANNER_G	  = 12;
	//const BANNER_H	  = 13;
	//const BANNER_I		= 14;
	const BANNER_J	= 15;
	const BANNER_GALLERIES_A		= 20;
	const BANNER_GALLERIES_B		= 21;
	const SKYCRAPER_D2  = 22;
	const BANNER_POSTS_A = 23;

	public function get_by_type($type) 
	{
		if (is_array($type))
		{
			$this->and_where_open();
			foreach ($type as $t)
			{
				$this->or_where('ad_type', '=', $t);
			}
			$this->and_where_close();
		} 
		else 
		{
			$this->where('ad_type', '=', $type);
		}

		$this->_add_availability_clauses();

		$this->order_by(DB::expr('RAND()'));

		$this->find();

		if ($this->loaded())
		{
			$this->inc_display_count();
			return $this;
		}
		return FALSE;
	}
	
	public function get_by_type_many($type, $limit = 2)
	{
		$this->where('ad_type', '=', $type);
		
		$this->_add_availability_clauses();

		$this->order_by(DB::expr('RAND()'));
		$this->limit($limit);

		$ads = $this->find_all();

		foreach ($ads as $ad)
		{
			if ($ad->loaded())
			{
				$ad->inc_display_count();
			}
		}
		
		return $ads;
	}
	
	public function find_by_types($types, $options = NULL)
	{
		$this->where('ad_type', 'IN', $types);
		
		$this->_add_availability_clauses();

		$this->order_by(DB::expr('RAND()'));
		$this->limit(Arr::get($options, 'limit', 1));

		$ads = $this->find_all();

		foreach ($ads as $ad)
		{
			if ($ad->loaded())
			{
				$ad->inc_display_count();
			}
		}
		
		return $ads;
	}
	
	public function count_by_types($types)
	{
		$this->where('ad_type', 'IN', $types);
		
		$this->_add_availability_clauses();
		
		return $this->count_all();
	}

	public function inc_display_count()
	{
		$this->ad_display_count = intval($this->ad_display_count) + 1;
		$this->save();
	}

	protected function _add_availability_clauses() 
	{
		$this->where('ad_date_start', '<', date('Y-m-d H:i:s'));
		$this->where('ad_availability', '>', date('Y-m-d H:i:s'));
		$this->where('ad_clicks_count', '<', DB::expr('ad_clicks'));
		$this->where('ad_is_paid', '=', 1);
	}

	public function add_text_ad_site($data, Model_User $user = NULL)
	{
		$data['ad_availability_span'] = $data['ad_availability'];
		
		switch ($data['ad_availability'])
		{
			case 14:
				$data['ad_availability'] = time() + 60*60*24*14;
				break;

			case 30:
				$data['ad_availability'] = time() + 60*60*24*30;
				break;
		}

		$data['ad_availability'] = date('Y-m-d H:i:s', $data['ad_availability']);
		$data['ad_type'] = self::TEXT_C;
		$data['ad_date_added'] = date('Y-m-d H:i:s');
		$data['ad_clicks'] = 999999999;
		$data['ad_is_paid'] = 0;
		
		if(empty($data['ad_date_start']))
		{
			$data['ad_date_start'] = date('Y-m-d H:i:s');
		}
		
		if($user AND $user->loaded())
		{
			$this->user_id = $user->pk();
		}
		
		$this->values($data)->save();
		
		return $this;
	}
	
	public function pay()
	{
		$this->ad_is_paid = 1;
		$this->save();
	}

	public function inc_clicks()
	{
		$this->ad_clicks_count = intval($this->ad_clicks_count) + 1;
		$this->save();
	}
	
	public function get_admin($offset, $limit, array $filters)
	{
		$this
				->_apply_filters($filters)
				->order_by('ad_id', 'DESC')
				->with('user')
				->limit($limit)
				->offset($offset);
		
		return $this->find_all();
	}
	
	public function count_admin(array $filters)
	{
		$this->_apply_filters($filters);
		return $this->count_all();
	}

	protected function _apply_filters(array $filters)
	{
		if ( ! empty($filters['which']))
		{
			if ($filters['which'] == 'active')
			{
				$this->_add_availability_clauses();
			}
			elseif ($filters['which'] == 'not_active')
			{
				$this->where_open();
				$this->where('ad_date_start', '>', date('Y-m-d H:i:s'));
				$this->or_where('ad_availability', '<', date('Y-m-d H:i:s'));
				$this->or_where('ad_clicks_count', '>=', DB::expr('ad_clicks'));
				$this->or_where('ad_is_paid', '!=', 1);
				$this->where_close();
			}
		}
		
		if ( ! empty($filters['user_id']))
		{
			$this->where('ad.user_id', '=', $filters['user_id']);
		}
		
		return $this;
	}
	
	public function edit_ad(array $values)
	{
		$this->values($values)->save();
	}
	
	public function add_ad(array $values)
	{
		$user = new Model_User;
		$adsystem_link = Route::url('adsystem', NULL, 'http');
		
		if ($values['user_id'] == 'new')
		{
			$values['user_status'] = 1;
			$values['user_is_paid'] = TRUE;
			$values['groups'] = array('Adsystem');
			$values['user_id'] = $user->add_user($values);
			
			$email = new Model_Email();
			if($email->find_by_alias('adsystem_create_user')->loaded())
			{
				$email->set_tags(array(
					'%username%' => $values['user_name'],
					'%password%' => $values['user_pass'],
					'%link%' => $adsystem_link,
				));
				$email->send($values['user_email']);
			}
		}
		else
		{
			$user = $user->find_by_pk($values['user_id']);
			
			if ( ! $user->has_group('Adsystem')) 
			{
				$user->add_group('Adsystem');
			}
			
			$email = new Model_Email();
			if($email->find_by_alias('adsystem_info')->loaded())
			{
				$email->set_tags(array(
					'%user_name%' => $user->user_name,
					'%adsystem_link%' => $adsystem_link,
				));
				$email->send($user->user_email);
			}
		}
		
		if (empty($values['ad_clicks']))
		{
			$values['ad_clicks'] = 999999999;
		}
		
		$values['ad_is_paid'] = 1;
		$values['ad_date_added'] = date('Y-m-d H:i:s');
		
		if(empty($values['ad_date_start']))
		{
			$values['ad_date_start'] = date('Y-m-d H:i:s');
		}
		
		$this->values($values)->save();
	}
	
	public function cron_expiring_ads()
	{
		$this
			->with('user')
			->where(DB::expr('DATEDIFF(ad_availability, NOW())'), '=', 2);
		
		return $this->find_all();
	}
}
