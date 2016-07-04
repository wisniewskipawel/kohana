<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Emails_Admin extends Event {

	public function on_menu_settings()
	{
		return View::factory('component/emails/admin_menu_settings');
	}

}
