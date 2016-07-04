<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

abstract class Controller_Admin_Main extends Controller_Base {

	protected $_session = NULL;
	protected $_auth = NULL;
	
	public $template_data = array();

	public $template = 'admin/layout_main';

	public function before() 
	{
		$this->_session = Session::instance();
		$this->_auth = BAuth::instance();

		$this->logged_only();

		if(!$this->_auth->is_admin()) 
		{
			$this->request->action('no_permissions');
		}

		if(!$this->permissions()) 
		{
			$this->request->action('no_permissions');
		}
		
		Events::fire('admin/main/before', array('controller' => $this));

		parent::before();

		$this->template->set_global('auth', $this->_auth);
		$this->template->set_global('session', $this->_session);
		$this->template->set_global('user_name', $this->_session->get('user_name', ''));
	}

	public function after() 
	{
		foreach($this->template_data as $name => $value)
		{
			$this->template->set($name, $value);
		}
		
		$this->template->uris = breadcrumbs::get();
		parent::after();
	}
	
	protected function set_title($title, $prepend = TRUE)
	{
		$title = UTF8::trim($title);
		
		if(empty($title))
			return NULL;
		
		if($prepend)
		{
			$this->template_data['title'] = $title.' - '.Arr::get($this->template_data, 'title');
		}
		else
		{
			$this->template_data['title'] = $title;
		}
		
		return $title;
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
			$this->redirect(BAuth::uri_login($this->request, Route::get('admin/login')->uri()));
		}
	}
	
	public function redirect_referrer($default_route = 'admin')
	{
		return parent::redirect_referrer($default_route);
	}
	
	public function permissions()
	{
		$uri = $this->request->directory().'/'.$this->request->controller().'/'.$this->request->action();
		return $this->_auth->permissions($uri);
	}

	public function action_no_permissions()
	{
		$this->template = View::factory('admin/error');
		$this->template->content = View::factory('admin/errors/no_permissions');
	}

}
