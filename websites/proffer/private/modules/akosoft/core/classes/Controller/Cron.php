<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron extends Controller {
	
	public function action_run()
	{
		if($this->request->param('token') != Kohana::$config->load('global.cron.token'))
		{
			throw new HTTP_Exception_404;
		}
		
		if(Kohana::$environment == Kohana::DEVELOPMENT)
		{
			Cron::set_log(TRUE);
			
			$this->response->headers('Content-Type', 'text/plain');
			$this->response->send_headers();
		}
		
		Cron::run();
	}
	
	public function action_execute()
	{
		if(!$this->request->is_initial() OR Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$cron = $this->request->query('cron');

			$content = Request::factory($cron)
				->execute()
				->body();

			$this->response->body($content);
		}
		else
		{
			throw new HTTP_Exception_404;
		}
	}
	
}