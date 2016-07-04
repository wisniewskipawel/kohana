<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Overlay_Frontend extends Events {
	
	public function on_after()
	{
		$overlay = Kohana::$config->load('global.layout.overlay.type');
		
		if($overlay && !Cookie::get('overlay_displayed'))
		{
			Media::css('overlay.css', NULL, array('minify' => TRUE, 'combine' => FALSE));
		}
	}
	
	public function on_footer()
	{
		$overlay = Kohana::$config->load('global.layout.overlay.type');
		
		if($overlay && !Cookie::get('overlay_displayed'))
		{
			Cookie::set('overlay_displayed', TRUE, Date::MONTH);
			
			try
			{
				return View::factory('overlays/'.$overlay)->render();
			}
			catch(Exception $ex)
			{
				Kohana::$log->add(Log::WARNING, '(site_overlay) Cannot display overlay: :error', array(
					':error' => Kohana_Exception::text($ex)
				));
			}
		}
	}
	
}