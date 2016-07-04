<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Subdomain_Errors extends Controller_Template {
	
	public $template = 'blank';
	
	public function action_404()
	{
		$this->response->status(404);
		$this->template->content = View::factory('frontend/errors/404');
	}

	public function action_500()
	{
		$this->response->status(500);
		$this->template->content = View::factory('frontend/errors/500');
	}
	
}
