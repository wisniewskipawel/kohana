<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Print extends Controller_Base {
	
	public function before()
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
		
		$this->template = 'print';
		
		parent::before();
	}
	
} 