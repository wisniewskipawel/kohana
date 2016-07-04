<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Base extends Controller_Template {
	
	protected $_before_login_referrer = NULL;
	
	public function before()
	{
		parent::before();
		
		$this->_before_login_referrer = $this->_session->get_once('before_login_referrer');
	}
	
	public function logged_only()
	{
		if ($this->_auth->is_logged()) 
		{
			return TRUE;
		}
		else 
		{
			$this->_session->set('before_login_referrer', $this->request->referrer());
			
			FlashInfo::add(___('users.login.alert'), 'error');
			$this->redirect(BAuth::uri_login($this->request));
		}
	}
	
	public function redirect_referrer($default_route = '/')
	{
		$redirect_uri = $this->_before_login_referrer;
		
		if(!$redirect_uri AND !in_array($this->request->referrer_route_name(), array(
			'bauth/frontend/auth/login',
			'admin/login',
		)))
		{
			$redirect_uri = $this->request->referrer();
		}
		
		return $this->redirect($redirect_uri ? $redirect_uri : $default_route);
	}
	
	protected function _keep_before_login_referrer()
	{
		$this->_session->set('before_login_referrer', $this->_before_login_referrer);
	}
	
}
