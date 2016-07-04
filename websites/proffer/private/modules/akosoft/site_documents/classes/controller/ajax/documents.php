<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Ajax_Documents extends Controller_Ajax_Main {

	public function action_get_url_input()
	{
		$content = View::factory('ajax/documents/ajax_get_url_input')
			->set('url', URL::title($this->request->param('id')))
			->render();

		$this->response->body($content);
	}   
}
