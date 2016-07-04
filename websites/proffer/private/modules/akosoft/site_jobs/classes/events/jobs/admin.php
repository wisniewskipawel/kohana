<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Events_Jobs_Admin extends Events {
	
	public function on_menu()
	{
		return View::factory('jobs/admin/menu');
	}
	
}
