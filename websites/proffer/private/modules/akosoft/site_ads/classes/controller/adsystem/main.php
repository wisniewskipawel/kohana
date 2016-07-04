<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Adsystem_Main extends Controller_Template {
    
	public $template = 'adsystem/layout_main';

	protected $_session = NULL;
	protected $_auth = NULL;

	public function before() 
	{
		$this->_session = Session::instance();
		$this->_auth = BAuth::instance();

		parent::before();

		$this->template->set_global('auth', $this->_auth);
		$this->template->set_global('session', $this->_session);
		$this->template->set_global('user_name', $this->_session->get('user_name', ''));
	}

	public function after() 
	{
		if ( ! $this->_auth->has_group('Adsystem'))
		{
			$this->redirect('/adsystem/auth/login');
		}

		$this->template->uris = array();
		parent::after();
	}
	
}
