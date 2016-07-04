<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Newsletter_Frontend extends Events {
	
	public function on_sidebar_left()
	{
		if(View_Template::instance('frontend')->config('site_newsletter.index_box_enabled'))
		{
			return Widget_Box::factory('newsletter');
		}
	}

	public function on_sidebar_right()
	{
		return View::factory('component/newsletter/sidebar_left');
	}
	
}
