<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Frontend_Frontend extends Events {
	
	public function on_main_bottom()
	{
		if(View_Template::instance('frontend')->config('modules_box_enabled'))
		{
			return Widget_Box::factory('modules')->render();
		}
	}
	
}