<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Auth extends Controller_Base {

	public $_session = null;
	public $_auth = null;
	
	public $template = 'admin/login';

	public function __construct($request, $response)
	{
		parent::__construct($request, $response);
		$this->_init();
	}

	protected function _init()
	{
		$this->_session = Session::instance();
		$this->_auth = BAuth::instance();
	}

	public function action_login()
	{
		$this->_keep_before_login_referrer();
		
		if($this->_auth->is_logged())
		{
			$this->redirect($this->_get_redirect_uri());
		}
		
		$form = Bform::factory('Auth_Login');

		if ($form->validate())
		{
			$result = $this->_auth->login(
				$form->user_name->get_value(), 
				$form->user_password->get_value(), 
				$form->remember->get_value()
			);

			if ($result === BAuth::OK_LOGGED_IN)
			{
				FlashInfo::add(___('users.login.success'), 'success');
				$this->redirect($this->_get_redirect_uri());
			}
			else
			{
				FlashInfo::add(BAuth::status_error_messages($result), 'error');
			}
		}

		$this->template->content = View::factory('admin/auth/login')
			->set('form', $form);
	}

	public function action_logout()
	{
		FlashInfo::add(___('users.logout.success'), 'success');
		$this->_auth->logout(FALSE);
		$this->redirect('/admin');
	}

	public function action_password_recovery()
	{
		$form = Bform::factory('Auth_PasswordRecovery');

		if ($form->validate())
		{
			$result = $this->_auth->lost_password_admin($form->email->get_value());

			if ($result)
			{
				FlashInfo::add(___('users.password_recovery.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('users.password_recovery.error.not_found'), 'error');
			}
			
			$this->redirect('/admin/auth/login');
		}

		$this->template->content = View::factory('admin/auth/password_recovery')
				->set('form', $form);
	}

	public function action_new_password()
	{
		$hash = $this->request->param('id', FALSE);

		if (!$hash)
		{
			throw new HTTP_Exception_404(404);
		}

		$form = Bform::factory('Auth_NewPassword');

		if ($form->validate())
		{
			$result = $this->_auth->set_new_password($hash, $form->user_pass->get_value());

			if ($result)
			{
				FlashInfo::add(___('users.new_password.success'), 'success');
			}
			else
			{
				FlashInfo::add(___('users.new_password.error'), 'error');
			}

			$this->redirect('/admin/auth/login');
		}

		$this->template->content = View::factory('admin/auth/new_password')
				->set('form', $form);
	}
	
	protected function _get_redirect_uri()
	{
		$redirect_uri = $this->request->query('redirect');
		
		if(!$redirect_uri)
		{
			$redirect_uri = $this->_session->get_once('redirect_url');
		}
		
		return $redirect_uri ? $redirect_uri : 'admin';
	}
	
}
