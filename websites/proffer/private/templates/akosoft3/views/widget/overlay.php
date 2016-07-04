<?php
$overlay = Kohana::$config->load('global.layout.overlay.type');
		
if($overlay && !Cookie::get('overlay_displayed'))
{
	Cookie::set('overlay_displayed', TRUE );

	try
	{
		echo View::factory('overlays/'.$overlay)->render();
	}
	catch(Exception $ex)
	{
		Kohana::$log->add(Log::WARNING, '(site_overlay) Cannot display overlay: :error', array(
			':error' => Kohana_Exception::text($ex)
		));
	}
}