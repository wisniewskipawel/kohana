<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class BAuth_Facebook {
	
	protected $_request;
	protected $_session;
	protected $_config;
	
	public function __construct(Request $request, Session $session)
	{
		$this->_request = $request;
		$this->_session = $session;
		$this->_config = Kohana::$config->load('modules.bauth.facebook');
		
		if(!Arr::get($this->_config, 'enabled', FALSE) OR empty($this->_config['app_id']) OR empty($this->_config['app_secret']))
		{
			throw new Kohana_Exception('Facebook login is disabled!');
		}
	}
	
	public function login()
	{
		$code = $this->_request->query('code');
		
		if($code)
		{
			$state = $this->_request->query('state');
			
			if(Security::check($state))
			{
				return $this->_do_login($code);
			}
			else
			{
				throw new Kohana_Exception('Wrong state token!');
			}
		}
		else
		{
			$token = Security::token();
			
			$login_url = "https://www.facebook.com/dialog/oauth?".http_build_query(array(
				'client_id' => $this->_config['app_id'],
				'redirect_uri' => Route::url('bauth/frontend/facebook/login', NULL, 'http'),
				'state' => $token,
				'scope' => 'email',
			));
			
			HTTP::redirect($login_url);
		}
	}
	
	protected function _do_login($code)
	{
		$token_url = "https://graph.facebook.com/oauth/access_token?"
			. "client_id=" . $this->_config['app_id'] . "&redirect_uri=" . urlencode(Route::url('bauth/frontend/facebook/login', NULL, 'http'))
			. "&client_secret=" . $this->_config['app_secret'] . "&code=" . $code;
		
		$access_token_request = Request::factory($token_url);
		$response = $access_token_request->execute()->body();
		
		$params = array();
		parse_str($response, $params);
		
		if(!isset($params['access_token']))
		{
			Kohana::$log->add(Log::WARNING, 'FB Auth: Cannot get access token :error', array(
				':error' => Arr::get($params, 'error'),
			))->write();
			
			return FALSE;
		}
		
		$this->_session->set('fb_access_token', $params['access_token']);
		
		$user_info = $this->get_user_info();
		
		if(!isset($user_info->verified) OR !$user_info->verified)
		{
			FlashInfo::add(___('users.facebook.not_verified'), 'error');
			return FALSE;
		}
		
		$user = new Model_User();
		$user->where('fb_user_id', '=', $user_info->id)
			->or_where('user_email', '=', $user_info->email);
		
		if($user->find()->loaded())
		{
			//login
			return BAuth::instance()->force_login($user);
		}
		else
		{
			//new user
			HTTP::redirect(Route::get('bauth/frontend/facebook/register')->uri());
		}
	}
	
	public function get_user_info()
	{
		$access_token = $this->_session->get('fb_access_token');
		if(!$access_token)
		{
			throw new Kohana_Exception('Wrong facebook access token!');
		}
		
		$request = Request::factory("https://graph.facebook.com/me".URL::query(array(
			'access_token' => $access_token,
			'fields' => 'id,email,first_name,gender,last_name,link,locale,name,verified',
		), FALSE));
		
		$response = $request->execute()->body();
		
		if(!$response)
		{
			return NULL;
		}
		
		$user_info = json_decode($response);
		
		if(!$this->verify_user_info($user_info))
		{
			Kohana::$log->add(Log::EMERGENCY, 'Wrong Facebook user info response: :data', array(
				':data' => print_r($user_info),
			));
			
			throw new Kohana_Exception('Wrong Facebook user info response!');
		}
		
		return $user_info;
	}
	
	protected function verify_user_info($user_info)
	{
		return !empty($user_info->id)
			AND !empty($user_info->email)
			AND !empty($user_info->verified);
	}
	
}