<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Cron_Main extends Controller {
	
	public function before()
	{
		parent::before();
		
		if($this->request->is_initial() AND Kohana::$environment != Kohana::DEVELOPMENT)
		{
			throw new HTTP_Exception_404();
		}
		
		$_SERVER['SERVER_NAME'] = $_SERVER['SERVER_NAME'] = Tools::server_name(Kohana::$config->load('global.site.url'));
		
		if(!Kohana::$safe_mode)
		{
			set_time_limit(0);
		}
	}
}
