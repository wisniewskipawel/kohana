<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class BAuth {

	const OK_ACTIVATED			= 2;
	const OK_LOGGED_IN			= 1;
	
	const E_USER_NOT_EXIST		= 0;
	const E_BAD_PASS			= -1;
	const E_USER_NOT_ACTIVE	= -2;
	const E_USER_BANNED		= -3;
	const E_USER_DELETED		= -4;
	const E_HASH_NOT_EXIST		= -5;
	const E_USER_IS_ACTIVE		= -6;
	const E_USER_NOT_PAID		= -7;

	protected static $_instance = NULL;

	protected $_session = NULL;
	
	protected $_user = NULL;
	protected $_user_groups = NULL;
	protected $_user_permissions = NULL;

	public static function instance() 
	{
		if (self::$_instance == NULL) 
		{
			self::$_instance = new self;
		}
		
		return self::$_instance;
	}

	public function __construct() 
	{
		$this->_session = Session::instance();

		if($this->is_logged() && intval($this->_session->get('last_active', 0)) < (time() - (Date::HOUR * 2)) && ! cookie::get('auto_login')) 
		{
			$url = Request::$current->url('http');
			$this->_session->set('redirect_url', $url);
			
			FlashInfo::add(___('users.session.expired'), 'error', TRUE);
			$this->logout();
		}

		$this->auto_login();
	}
	
	public function force_login(Model_User $user)
	{
		if ($user !== FALSE AND $user->loaded()) 
		{
			if ($user->user_status == Model_User::STATUS_ACTIVE) 
			{
				if ( ! $user->user_is_paid)
				{
					return self::E_USER_NOT_PAID;
				}
				
				$this->_login($user, FALSE);

				return self::OK_LOGGED_IN;
			}
			else 
			{
				switch ($user->user_status) 
				{
					case Model_User::STATUS_NOT_ACTIVE:
						return self::E_USER_NOT_ACTIVE;
					case Model_User::STATUS_BANNED:
						return self::E_USER_BANNED;
					case Model_User::STATUS_DELETED:
						return self::E_USER_DELETED;
				}
			}
		}
		else 
		{
			return self::E_USER_NOT_EXIST;
		}
	}

	public function login($username, $password, $auto_login = FALSE) 
	{
		$user = Model_User::factory()->get_user_by_name_or_email($username);

		if ($user !== FALSE) 
		{
			if ($user->user_status == Model_User::STATUS_ACTIVE) 
			{
				if ( ! $user->user_is_paid)
				{
					return self::E_USER_NOT_PAID;
				}
				
				if ($user->user_pass == self::hash_password($password)) 
				{
					$this->_login($user, $auto_login);

					return self::OK_LOGGED_IN;
				}
				else 
				{
					return self::E_BAD_PASS;
				}
			}
			else 
			{
				switch ($user->user_status) 
				{
					case Model_User::STATUS_NOT_ACTIVE:
						return self::E_USER_NOT_ACTIVE;
					case Model_User::STATUS_BANNED:
						return self::E_USER_BANNED;
					case Model_User::STATUS_DELETED:
						return self::E_USER_DELETED;
				}
			}
		}
		else 
		{
			return self::E_USER_NOT_EXIST;
		}
	}

	public function auto_login() 
	{
		if($this->_session->get('is_logged', 0) == 1)
		{
			return TRUE;
		}

		$token = cookie::get('auto_login', NULL);

		if($token !== NULL) 
		{
			$user = Model_User::factory()
				->where('user.user_autologin', '=', $token)
				->with('data')
				->find();

			if($user->loaded()) 
			{
				if($user->user_status == Model_User::STATUS_ACTIVE AND $user->user_is_paid) 
				{
					$this->_login($user, TRUE);

					FlashInfo::add(___('users.session.restored'), 'success');

					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	protected function _login(Model_User $user, $auto_login)
	{
		$this->_session->set('is_logged' , 1);
		$this->_session->set('user_id', $user->user_id);
		$this->_session->set('user_name', $user->user_name);

		if ($auto_login) 
		{
			$token = $this->_create_token();
			// cookie for 2 weeks
			cookie::set('auto_login', $token, Date::WEEK * 2);
			$data['user_autologin'] = $token;
		}

		$this->_session->set('user_last_login', $user->user_last_login_date);
		
		$data['user_last_login_date'] = time();
		$user->edit_user($data)->save();
		
		$this->_user = $user;
		
		return TRUE;
	}

	public function register($data) 
	{
		$user = Model_User::factory()->add_user($data);
		
		return $user;
	}

	public function activate($user_hash) 
	{
		$user = Model_User::factory()->find_by_hash($user_hash);

		if ($user->loaded()) 
		{
			return $this->activate_user($user);
		}
		
		return self::E_HASH_NOT_EXIST;
	}

	public function activate_user(Model_User $user) 
	{
		if ($user->loaded()) 
		{
			if ($user->user_status == Model_User::STATUS_NOT_ACTIVE) 
			{
				$data['user_status'] = Model_User::STATUS_ACTIVE;
				$data['rebuild_hash'] = TRUE;
				$user->edit_user($data)->save();

				return self::OK_ACTIVATED;
			}
			else
			{
				switch ($user->user_status) 
				{
					case Model_User::STATUS_ACTIVE:
						return self::E_USER_IS_ACTIVE;
					case Model_User::STATUS_BANNED:
						return self::E_USER_BANNED;
					case Model_User::STATUS_DELETED:
						return self::E_USER_DELETED;
				}
			}
		}
		
		return FALSE;
	}

	public function lost_password($email) 
	{
		$user = Model_User::factory()
			->where('user.user_email', '=', $email)
			->with('data')
			->find();
		
		if ($user->loaded()) 
		{
			$subject = ___('users.lost_password.email.subject') . ' ' . URL::site('/', 'http');
			$message = View::factory('email/users/email_confirm_lostpass')
					->set('user_name', $user->user_name)
					->set('user_hash', $user->user_hash)
					->set('ip', Request::$client_ip)
					->set('host', gethostbyaddr(Request::$client_ip))
					->set('user_agent', Request::$user_agent);

			Email::send($user->user_email, $subject, $message);

			return TRUE;
		}
		
		return FALSE;
	}


	public function lost_password_admin($email)
	{
		$user = Model_User::factory()
			->where('user.user_email', '=', $email)
			->with('data')
			->find();
		
		if ($user->loaded()) 
		{
			$subject = ___('users.lost_password.email.subject') . ' ' . URL::site('/', 'http');
			$message = View::factory('email/users/email_confirm_lostpass_admin')
					->set('user_name', $user->user_name)
					->set('user_hash', $user->user_hash)
					->set('ip', Request::$client_ip)
					->set('host', gethostbyaddr(Request::$client_ip))
					->set('user_agent', Request::$user_agent);

			Email::send($user->user_email, $subject, $message);

			return TRUE;
		} 
		
		return FALSE;
	}

	protected function _create_token() 
	{
		$model = new Model_User;
		
		do
		{
			$token = Text::random('alnum', 40);
		}
		while(!$model->unique('user_autologin', $token));
		
		return $token;
	}

	public static function hash_password($password) 
	{
		$salt = Kohana::$config->load('bauth.salt');
		$password = sha1($password . $salt);
		return $password;
	}

	public function logout($destroy = FALSE) 
	{
		if ($destroy == TRUE) 
		{
			$this->_session->destroy();
		}
		else 
		{
			$this->_session->delete('user_id', 'user_name', 'is_logged', 'user_groups', 'user_last_login');
		}
		cookie::delete('auto_login');
	}

	public function is_logged() 
	{
		if($this->_session->get('is_logged', 0) == 1) 
		{
			return !!$this->_load_user();
		}
		
		return FALSE;
	}

	public function has_group($name) 
	{
		if($groups = $this->get_user_groups())
		{
			foreach($groups as $group)
			{
				if($group->group_name == $name)
				{
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	public function has_groups(array $groups)
	{
		foreach ($groups as $name)
		{
			if ( ! $this->has_group($name))
			{
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	public function get_user_groups()
	{
		if($this->_user_groups)
		{
			return $this->_user_groups;
		}
		
		if($user = $this->get_user())
		{
			$this->_user_groups = $user->groups->find_all();
		}
		
		return $this->_user_groups;
	}

	public function is_admin() 
	{
		if($this->is_logged())
		{
			if($groups = $this->get_user_groups())
			{
				foreach($groups as $group)
				{
					if($group->group_is_admin)
					{
						return TRUE;
					}
				}
			}
		}
		
		return FALSE;
	}
	
	protected function _load_user()
	{
		if($this->_user AND $this->_user instanceof Model_User AND $this->_user->loaded())
		{
			return $this->_user;
		}
		
		if($this->_session->get('user_id'))
		{
			$user = Model_User::factory()
				->with('data')
				->find_by_pk($this->_session->get('user_id'));

			if($user AND $user->loaded())
			{
				return $this->_user = $user;
			}
		}
		
		return FALSE;
	}

	public function get_user() 
	{
		if(!$this->is_logged())
			return FALSE;

		return $this->_load_user();
	}
	
	public function get_user_id()
	{
		$user = $this->get_user();
		return $user ? $user->pk() : NULL;
	}
	
	public function get_user_permissions()
	{
		if($this->_user_permissions !== NULL)
		{
			return $this->_user_permissions;
		}
		
		if($user = $this->get_user())
		{
			$this->_user_permissions = array();
			
			foreach($user->groups->find_all() as $group)
			{
				$this->_user_permissions = array_merge(
					$this->_user_permissions, 
					$group->permissions->find_all()->as_array('id', 'permission')
				);
			}
			
			return $this->_user_permissions;
		}
		
		return $this->_user_permissions;
	}

	public function permissions($uri) 
	{
		if($this->has_group('SuperAdministrator')) 
		{
			return TRUE;
		}
		
		$group_permissions = $this->get_user_permissions();
		
		if(!$group_permissions)
		{
			return FALSE;
		}
		
		$uri = strtolower($uri);
			
		return in_array($uri, $group_permissions);
	}
	
	public static function status_error_messages($status)
	{
		$messages = array(
			BAuth::E_USER_NOT_EXIST	=> ___('users.auth.errors.not_exists'),
			BAuth::E_BAD_PASS			=> ___('users.auth.errors.bad_pass'),
			BAuth::E_USER_NOT_ACTIVE	=> ___('users.auth.errors.not_active'),
			BAuth::E_USER_BANNED		=> ___('users.auth.errors.banned'),
			BAuth::E_USER_DELETED		=> ___('users.auth.errors.deleted'),
			BAuth::E_USER_NOT_PAID		=> ___('users.auth.errors.not_paid'),
		);
		
		return Arr::get($messages, $status, ___('users.auth.errors.other_error'));
	}
	
	public static function person_types()
	{
		return array(
			'person'	=> ___('person'),
			'company'	=> ___('company'),
		);
	}
	
	public static function uri_login($redirect = NULL, $login_uri = NULL)
	{
		if(!$login_uri)
		{
			$login_uri = Route::get('bauth/frontend/auth/login')->uri();
		}
		
		if($redirect)
		{
			if($redirect === TRUE)
			{
				$redirect = Request::current();
			}
			
			if($redirect instanceof Request)
			{
				$redirect = $redirect->uri().URL::query($redirect->query(), FALSE);
			}
			
			$login_uri .= URL::query(array('redirect' => $redirect), FALSE);
		}
		
		return $login_uri;
	}
	
}
