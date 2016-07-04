<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Ajax_Ads extends Controller_Ajax_Main {
    
	public function action_get_ad_availability()
	{
		$type = $this->request->query('type');

		$body = View::factory('ajax/ads/get_ad_availability')->set('type', $type)->render();

		$this->response->body($body);
	}
}
