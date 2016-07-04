<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Frontend_Main extends Controller_Base {

	public $template_data = array();
	
	public $_auth = NULL;
	public $_session = NULL;
	
	/**
	 * @var	Model_User	current logged user 
	 */
	protected $_current_user = NULL;
	
	protected $_action_tab = NULL;

	public function __construct($request, $response)
	{
		parent::__construct($request, $response);
		$this->_init();
	}

	protected function _init()
	{
		$this->_auth = BAuth::instance();
		
		if($this->_auth->is_logged())
		{
			$this->_current_user = $this->_auth->get_user();
			Register::set('current_user', $this->_current_user);
		}
		
		$this->_session = Session::instance();
		
		if(Kohana::$config->load('global.site.disabled') AND Route::name($this->request->route()) != 'error')
		{
			if(!$this->_auth->is_admin())
			{
				throw new HTTP_Exception_503();
			}
		}
		
		$this->template = View_Template::instance('frontend');
	}

	public function  before() 
	{   
		parent::before();
		
		Events::fire('frontend/before', array(
			'template' => $this->template,
		));
		
		if(!$this->_action_tab)
		{
			$current_module = Modules::instance()->current_module();
			
			$this->_action_tab = ($current_module && $current_module->param('home_module')) ? 
				$current_module->get_name() : NULL;
		}
	}
	
	public function after()
	{
		if($this->auto_render)
		{
			$this->template->set_global('auth', $this->_auth);
			$this->template->set_global('session', $this->_session);
			$this->template->set_global('current_user',  $this->_current_user);
			$this->template->set_global('current_request',  $this->request);
			$this->template->set_global('current_route_name',  Route::name($this->request->route()));
		
			$this->template->set_global('action_tab',  $this->_action_tab);
			
			foreach($this->template_data as $name => $value)
			{
				$this->template->set($name, $value);
			}
			
			if(isset($this->template->content) AND $this->template->content instanceof View)
			{
				//force render view to execute assets
				$this->template->content = $this->template->content->render();
			}
		}
		
		Events::fire('frontend/after', array(
			'controller' => $this,
		));
		
		parent::after();
	}
	
	protected function _age_confirm()
	{
		if (cookie::get('age_confirmed'))
		{
			cookie::set('age_confirmed',  TRUE, 15*Date::MINUTE);
			return TRUE;
		}
		
		$document = Pages::get('age_confirm');

		$post = $this->request->post();
		
		if ($post)
		{
			if ( ! empty($post['y']))
			{
				cookie::set('age_confirmed',  TRUE, !empty($post['remember']) ? 3*Date::MONTH : 15*Date::MINUTE);
				return TRUE;
			}
			
			if ( ! empty($post['n']))
			{
				$this->redirect('/');
			}
		}
		
		$this->template->content = View::factory('partials/age_confirm')
				->set('document', $document);
		
		$this->template->set_title(___('age_confirm.title'));
		
		return FALSE;
	}
	
}
