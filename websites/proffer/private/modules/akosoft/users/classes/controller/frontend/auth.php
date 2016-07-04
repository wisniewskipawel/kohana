<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 *
 */

class Controller_Frontend_Auth extends Controller_Frontend_Main {
	
	public function action_login()
	{
		$this->_keep_before_login_referrer();
		
		if ($this->_auth->is_logged())
		{
			FlashInfo::add(___('users.login.already_logged'), 'success');
			$this->redirect($this->_get_redirect_uri());
		}

		$form = BForm::factory('Auth_Login');

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
				$this->redirect(Route::url('bauth/frontend/auth/login', NULL, 'http').URL::query(array(
					'redirect' => $this->_get_redirect_uri(),
				), FALSE));
			}
		}

		$this->template->content = View::factory('auth/login')
				->set('form', $form);

		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			$this->template->set_title(___('users.login.title'))	=> ''
		));
	}

	public function action_logout()
	{
		FlashInfo::add(___('users.logout.success'), 'success');
		$this->_auth->logout(FALSE);
		$this->redirect(Route::url('bauth/frontend/auth/login', NULL, 'http'));
	}

	public function action_register()
	{
		$payment_module = new Payment_User;
		$payment_module->place('register');
		
		$form = Bform::factory('Auth_Register', array('payment_module' => $payment_module));

		if ($form->validate())
		{
			$values = $form->get_values();
			$values['user_is_paid'] = !$payment_module->is_enabled();
			$user = $this->_auth->register($values);
			
			if(Modules::enabled('site_newsletter') AND !empty($values['accept_terms']))
			{
				Newsletter::subscribe(Arr::get($values, 'user_email'), !empty($values['accept_ads']));
			}
			
			if ($payment_module->is_enabled())
			{
				$payment_module->load_object($user);
				$payment_module->set_params(array('id' => $user->pk()));
				$payment_module->pay(Arr::get($values, 'payment_method'));
			}
			else
			{
				$user->send_activation_email(Arr::get($values, 'user_pass'));
				
				FlashInfo::add(___('users.register.success', 'activate'), 'success');
				$this->redirect(Route::url('bauth/frontend/auth/login').URL::query(array(
					'redirect' => $this->_get_redirect_uri(),
				), FALSE));
			}
		}

		$this->template->content = View::factory('auth/register')
				->set('form', $form)
				->set('payment_module', $payment_module);

		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			$this->template->set_title(___('users.register.title'))	=> ''
		));
	}

	public function action_activate()
	{
		$hash = $this->request->param('hash');
		
		$user = Model_User::factory()->find_by_hash($hash);
		
		if($user->loaded() AND $this->_auth->activate_user($user) == BAuth::OK_ACTIVATED)
		{
			FlashInfo::add(___('users.activate.success'), FlashInfo::SUCCESS);
			$this->_auth->force_login($user);
			
			$this->redirect(Route::get('site_profile/profile/settings/change')->uri());
		}
		else
		{
			FlashInfo::add(___('users.activate.error'), FlashInfo::ERROR);
		}

		$this->redirect(Route::url('index'));
	}

	public function action_lost_password()
	{
		$form = Bform::factory('Auth_LostPassword');

		if ($form->validate())
		{
			$result = $this->_auth->lost_password($form->user_email->get_value());
		
			if($result)
			{
				FlashInfo::add(___('users.lost_password.success'), FlashInfo::SUCCESS);
			}
			else
			{
				FlashInfo::add(___('users.lost_password.error'), FlashInfo::ERROR);
			}

			$this->redirect(Route::url('bauth/frontend/auth/lost_password', NULL, 'http'));
		}

		$this->template->content = View::factory('auth/lost_password')
				->set('form', $form);

		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			$this->template->set_title(___('users.lost_password.title'))	=> ''
		));
	}

	public function action_new_password()
	{
		$hash = $this->request->param('hash');
		
		if ( ! $hash)
		{
			throw new HTTP_Exception_404;
		}

		$user = ORM::factory('User')
				->where('user_hash', '=', $hash)
				->find();
		
		if ( ! $user->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory('Auth_NewPassword');

		if ($form->validate())
		{
			$user->edit_user(array('user_pass' => $form->user_pass->get_value()));
			
			FlashInfo::add(___('users.new_password.success'), 'success');
			$this->redirect(Route::url('bauth/frontend/auth/lost_password', NULL, 'http'));
		}

		$this->template->content = View::factory('auth/new_password')
				->set('form', $form);

		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			$this->template->set_title(___('users.new_password.title'))	=> ''
		));
	}
	
	public function action_send_activation_link()
	{
		$form = Bform::factory('Auth_SendActivationLink');

		if ($form->validate())
		{
			$values = $form->get_values();
			
			$user = ORM::factory('User')
				->where('user_email', '=', Arr::get($values, 'user_email'))
				->find();
		
			if ($user->loaded() && $user->user_status == Model_User::STATUS_NOT_ACTIVE)
			{
				$user->send_activation_email();
				FlashInfo::add(___('users.send_activation_link.success'), 'success');

				$this->redirect(Route::url('index'));
			}
			else
			{
				FlashInfo::add(___('users.send_activation_link.error'), 'error');
			}
		}
		
		breadcrumbs::add(array(
			___('homepage') => Route::url('index'),
			$this->template->set_title(___('users.send_activation_link.title'))	=> ''
		));

		$this->template->content = View::factory('auth/send_activation_link')
				->set('form', $form);
	}
	
	protected function _get_redirect_uri()
	{
		$redirect_uri = $this->request->query('redirect');
		
		if(!$redirect_uri)
		{
			$redirect_uri = $this->_session->get_once('redirect_url');
		}
		
		return URL::site($redirect_uri, 'http');
	}
	
}