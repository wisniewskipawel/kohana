<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Adsystem_Auth extends Controller_Template {

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
		$form = Bform::factory('Auth_Login');

		if ($form->validate())
		{
			$result = $this->_auth->login($form->user_name->get_value(), $form->user_password->get_value(), $form->remember->get_value());

			if ($result === BAuth::OK_LOGGED_IN)
			{
				FlashInfo::add(___('users.login.success'), 'success');
				$this->redirect('/adsystem');

			}
			else
			{
				FlashInfo::add(BAuth::status_error_messages($result), 'error');
				$this->redirect('/adsystem/auth/login');
			}
		}

		$this->template->content = View::factory('adsystem/auth/login')
				->set('form', $form);
	}

	public function action_logout()
	{
		FlashInfo::add(___('users.logout.success'), 'success');
		$this->_auth->logout(FALSE);
		$this->redirect('/adsystem');
	}
}
