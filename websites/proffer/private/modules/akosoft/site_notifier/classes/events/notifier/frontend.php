<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Notifier_Frontend extends Events {
	
	public function on_before()
	{
		Media::css('notifier.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
	}
	
	public function on_sidebar_left()
	{
		if(!$this->_is_current_module())
			return;
		
		$notifiers = Events::fire('notifiers/menu', NULL, TRUE);
		
		if(!empty($notifiers) AND count($notifiers) > 1)
		{
			return View::factory('component/notifier/sidebar')
				->set('notifiers', $notifiers)
				->set('route_name', $this->_route_name);
		}
	}
	
}
