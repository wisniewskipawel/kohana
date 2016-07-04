<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_BAuth_Facebook extends Controller_Frontend_Main {
	
	public function before()
	{
		parent::before();
		
		if($this->_auth->is_logged() OR !Kohana::$config->load('modules.bauth.facebook.enabled'))
		{
			$this->redirect();
		}
	}
	
	public function action_login()
	{
		$facebook = new BAuth_Facebook($this->request, $this->_session);
		$result = $facebook->login();
		
		if ($result === BAuth::OK_LOGGED_IN)
		{
			FlashInfo::add(___('users.login.success'), 'success');
			$this->redirect($this->_session->get_once('redirect_url', '/'));
		}
		else
		{
			FlashInfo::add(BAuth::status_error_messages($result), 'error');
			$this->redirect(Route::url('bauth/frontend/auth/login', NULL, 'http'));
		}
	}
	
	public function action_register()
	{
		$facebook = new BAuth_Facebook($this->request, $this->_session);
		$user_info = $facebook->get_user_info();
		
		//check e-mail blacklist
		if(Model_Email_BlackList::check_email($user_info->email))
		{
			FlashInfo::add(___('users.forms.validator.email.blacklist'), FlashInfo::ERROR);
			$this->redirect();
		}
		
		$payment_module = new Payment_User;
		$payment_module->place('register');
		
		$form = BForm::factory('Auth_Facebook_Register', array(
			'user_info' => $user_info, 
			'payment_module' => $payment_module,
		));
		
		if($form->validate())
		{
			$values = $form->get_values();
			$values['user_email'] = $user_info->email;
			$values['user_pass'] = Text::random('alnum', 32);
			$values['user_is_paid'] = !$payment_module->is_enabled();
			$values['user_status'] = Model_User::STATUS_ACTIVE;
			$values['fb_user_id'] = $user_info->id;
			
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
				FlashInfo::add(___('users.facebook.register.success'), 'success');
				$this->_auth->force_login($user);
				$this->redirect();
			}
		}
		
		breadcrumbs::add(array(
			'homepage'		=> URL::base(),
			'users.register.title'	=> '',
		));
		
		$this->template->content = View::factory('auth/facebook/register')
			->set('form', $form)
			->set('payment_module', $payment_module);
	}
	
}