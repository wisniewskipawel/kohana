<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Rss_Main extends Controller {
	
	public function render_rss($info, $items)
	{
		$this->response->headers('ContentType', 'application/rss');
		
		$this->response->body(View::factory('rss')
			->set('info', $info)
			->set('items', $items)
		);
	}
	
}
