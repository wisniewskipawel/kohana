<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Frontend_Ad extends Controller {
	
	public function action_show()
	{
		$place = $this->request->param('place');
		$options = $this->request->query();
		
		$ads = ads::get((int)$place, Arr::get($options, 'limit', 1));
		
		$this->auto_render = FALSE;
		
		$response = View::factory('frontend/ads/template')
			->set('ads', $ads);
		
		$this->response->body($response);
	}

}
