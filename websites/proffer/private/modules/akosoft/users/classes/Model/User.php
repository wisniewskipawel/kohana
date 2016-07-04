<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_User extends ORM implements IEmailMessageReceiver {

	const STATUS_NOT_ACTIVE 	= 0;
	const STATUS_ACTIVE 		= 1;
	const STATUS_BANNED 		= 2;
	const STATUS_DELETED 		= 3;

	protected $_table_name = 'users';
	protected $_primary_key = 'user_id';
	protected $_primary_val = 'user_name';

	protected $_has_many = array(
		'groups' => array('model' => 'User_Group', 'through' => 'users_to_groups', 'foreign_key' => 'user_id'),
	);
	protected $_has_one = array(
		'data' => array('model' => 'User_Data', 'foreign_key' => 'user_id')
	);
	
	protected $_contact_data = NULL;
	
	public function contact_data()
	{
		if(!$this->loaded() OR !$this->data->loaded())
		{
			return NULL;
		}
		
		if($this->_contact_data)
		{
			return $this->_contact_data;
		}
		
		$this->_contact_data = Contact::factory($this->data->users_data_person_type == 'company' ? 'company' : 'person');
		$this->_contact_data->name = $this->data->users_data_person;
		$this->_contact_data->phone = $this->data->users_data_telephone;
		$this->_contact_data->email = $this->get_email_address();
		$this->_contact_data->www = $this->data->users_data_www;

		$address = new Address();
		$address->province_id = $this->data->users_data_province;
		$address->province = Regions::province($this->data->users_data_province);
		$address->county_id = $this->data->users_data_county;
		$address->county = Regions::county($this->data->users_data_county, $this->data->users_data_province);
		$address->postal_code = $this->data->users_data_postal_code;
		$address->city = $this->data->users_data_city;
		$address->street = $this->data->users_data_street;

		$this->_contact_data->address = $address;
		
		return $this->_contact_data;
	}

	public function count_list(array $filters = array())
	{
		$this->_apply_filters($filters);
		return count($this->find_all());
	}

	public function get_list(array $filters, $offset = NULL, $limit = NULL)
	{
		$this->_apply_filters($filters);
		
		if ($offset !== NULL)
		{
			$this->offset($offset);
		}
		if ($limit !== NULL)
		{
			$this->limit($limit);
		}
		
		return $this->find_all();
	}
	
	public function with_statistics()
	{
		Events::fire('user/with_statistics', array('model' => $this));
		
		return $this;
	}

	protected function _apply_filters(array $filters) 
	{
		if ( ! empty($filters['without_groups']))
		{
			if ( ! is_array($filters['without_groups']))
			{
				throw new Exception("Check API!");
			}
			
			$this->without_groups($filters['without_groups']);
		}
		
		if ( ! empty($filters['with_groups']))
		{
			if ( ! is_array($filters['with_groups']))
			{
				throw new Exception("Check API!");
			}
			
			$this->with_groups($filters['with_groups']);
		}
		
		if ( ! empty($filters['login_or_email']))
		{
			$this->where_open();
			$this->where('user_name', 'LIKE', "%$filters[login_or_email]%");
			$this->or_where('user_email', 'LIKE', "%$filters[login_or_email]%");
			$this->where_close();
		}
		
		if ( ! empty($filters['is_online'])) 
		{
			if ($filters['is_online'] == 'yes') 
			{
				$this->join('sessions')->on('user.user_id', '=', 'sessions.user_id');
				$this->where('sessions.last_active', '>', time() - 60*60*5);
				$this->group_by('user.user_id');
			}
			elseif ($filters['is_online'] == 'no') 
			{
				$this->join('sessions', 'LEFT')->on('user.user_id', '=', 'sessions.user_id');
				$this->where_open();
				$this->where('sessions.last_active', '<', time() - 60*60*5);
				$this->or_where('sessions.last_active', 'IS', NULL);
				$this->where_close();
			}
		}
		
		if (empty($filters['order_by']))
		{
			$this->order_by('user.user_id', 'DESC');
		}
		
		$this->group_by('user.user_id');
	}

	public function edit_user($data) 
	{
		if ( ! empty($data['user_pass'])) 
		{
			$data['user_pass'] = BAuth::hash_password($data['user_pass']);
			$data['user_hash'] = self::factory($this->_object_name)->create_hash();
		}
		else 
		{
			unset($data['user_pass']);
		}
		
		$this->values($data)->save();
		
		if ( ! empty($data['groups'])) 
		{
			$this->add_groups($data['groups'], TRUE);
		}
		else
		{
			if ( ! empty($data['clear_groups']))
			{
				$this->delete_groups();
			}
		}
		
		
		if ( ! empty($data['data']))
		{
			$this->data->values($data['data'])->save();
		}
		return $this;
	}

	public function get_user_by_name_or_email($name) 
	{
		$user = $this
				->where('user_name', '=', $name)
				->with('user_data')
				->find();

		if ($user->loaded())
				return $user;

		$user = $this
				->where('user_email', '=', $name)
				->with('user_data')
				->find();

		if ($user->loaded())
				return $user;

		return FALSE;
	}

	public function get_user($id) 
	{
		$user = $this->where('user.user_id', '=', $id)
				->with('data')
				->find();

		if ($user->loaded())
				return $user;

		return FALSE;
	}
	
	public function find_by_hash($hash)
	{
		return $this->where('user_hash', '=', $hash)->find();
	}

	public function check_password($user_id, $password) 
	{
		$result = $this->where('user_id', '=', $user_id)->and_where('user_pass', '=', $password)->count_all();
		return (bool) $result;
	}

	public function check_user($name, $user_id = 0) 
	{
		$result = $this->where('user_name', '=', $name)->where('user_id', '<>', $user_id)->count_all();
		return (bool) $result;
	}

	public function check_email($email, $user_id = 0) 
	{
		$result = $this->where('user_email', '=', $email)->where('user_id', '<>', $user_id)->count_all();
		return (bool) $result;
	}

	public function add_user(array $values) 
	{
		$values['user_hash'] = ORM::factory('User')->create_hash();
		$values['user_ip'] = Request::$client_ip;
		$values['user_host'] = gethostbyaddr(Request::$client_ip);
		$values['user_registration_date'] = time();

		$this->values($values)->save();

		$this->data->user_id = $this->user_id;
		$this->data->values($values)->save();

		$this->edit_user($values);

		return $this;
	}
	
	public function save_avatar($files)
	{
		$file = Arr::get($files, 'avatar');
		
		if($file AND Upload::valid($file) AND Upload::not_empty($file))
		{
			if($path = Upload::save($file))
			{
				img::process_one($path, $this->pk(), 'user_avatars', 'user_avatars');
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function get_avatar()
	{
		if(img::image_exists('user_avatars', 'medium', $this->pk()))
		{
			return img::path_uri('user_avatars', 'medium', $this->pk());
		}
		
		return FALSE;
	}

	public function create_hash() 
	{
		while (TRUE) 
		{
			$hash = Text::random('alnum', 40);
			
			$result = (bool) self::factory($this->_object_name)
					->where('user_hash', '=', $hash)
					->count_all();

			if ( ! $result) 
			{
				return $hash;
			}
		}
	}

	public function with_groups(array $groups)
	{
		foreach ($groups as $group_name)
		{
			$this
					->where('user_id', 'IN', DB::expr("
						(
							SELECT
								pivot.user_id
							FROM
								users_to_groups AS pivot
							JOIN
								users_groups
							ON
								pivot.group_id = users_groups.group_id
							WHERE
								users_groups.group_name = '$group_name'
						)
					"));
		}
		
		return $this;
	}
	
	public function without_groups(array $groups)
	{
		foreach ($groups as $group_name)
		{
			$this
					->where('user.user_id', 'NOT IN', DB::expr("
						(
							SELECT
								pivot.user_id
							FROM
								users_to_groups AS pivot
							JOIN
								users_groups
							ON
								pivot.group_id = users_groups.group_id
							WHERE
								users_groups.group_name = '$group_name'
						)
			"));
		}
		
		return $this;
	}
	
	public function count_admins() 
	{
		$this->join('users_to_groups', 'INNER')
			->on('users_to_groups.user_id', '=', $this->object_name().'.user_id');
		
		$this->join('users_groups', 'INNER')
			->on('users_groups.group_id', '=', 'users_to_groups.group_id');
		
		$this->where('users_groups.group_is_admin', '=', TRUE);
		
		$this->group_by($this->object_name().'.user_id');
		
		return $this->count_all();
	}
	
	public function find_admins()
	{
		$this->join('users_to_groups', 'INNER')
			->on('users_to_groups.user_id', '=', $this->object_name().'.user_id');
		
		$this->join('users_groups', 'INNER')
			->on('users_groups.group_id', '=', 'users_to_groups.group_id');
		
		$this->where('users_groups.group_is_admin', '=', TRUE);
		
		$this->group_by($this->object_name().'.user_id');
		
		return $this->find_all();
	}

	public function add_group($name) 
	{
		if(!$name)
		{
			return FALSE;
		}
		
		$group = ORM::factory('User_Group')
			->where('group_name', '=', $name)
			->find();

		if ( ! $group->loaded()) 
		{
			throw new Exception("Group '$name' doesn't exists!");
		}

		$obj = ORM::factory('User_To_Group');
		$obj->user_id = $this->user_id;
		$obj->group_id = $group->group_id;
		$obj->save();
	}

	public function has_group($name) 
	{
		$result = ORM::factory('User_To_Group')
				->where('user_id', '=', $this->user_id)
				->where('group.group_name', '=', $name)
				->with('group')
				->find();

		return $result->group->loaded();
	}
	
	public function delete_groups()
	{
		DB::delete('users_to_groups')
				->where('user_id', '=', $this->user_id)
				->execute($this->_db);
		
		return $this;
	}

	public function add_groups(array $groups, $delete = FALSE) 
	{
		if ($delete)
		{
			$this->delete_groups();
		}

		foreach ($groups as $group_name) 
		{
			$this->add_group($group_name);
		}
	}

	public function delete() 
	{
		if ($this->loaded()) 
		{
			Model_User_To_Group::factory()->delete_by_user($this);

			$this->data->delete();
		}
		
		parent::delete();
	}
	
	public function send_new_account_email($password = NULL)
	{
		$email = ORM::factory('Email')
				->where('email_alias', '=', 'new_account')
				->find();
		
		$email->set_tags(array(
			'%username%' => $this->user_name,
			'%password%' => $password,
			'%link%'	 => HTML::anchor(URL::site('/', 'http'))
		));
		
		return $email->send($this->user_email);
	}
	
	public function send_activation_email($password = NULL)
	{
		$email = ORM::factory('Email')
				->where('email_alias', '=', 'confirm_account')
				->find();
	   
		$email->set_tags(array(
			'%username%' => $this->user_name,
			'%password%' => $password,
			'%link%'	 => HTML::anchor(
				Route::url('bauth/frontend/auth/activate', array('hash' => $this->user_hash), 'http')
			)
		));
		
		return $email->send($this->user_email);
	}

	public function get_email_address()
	{
		return $this->user_email;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}
		
		return Email::send($this->get_email_address(), $subject, $message, $params);
	}

}
