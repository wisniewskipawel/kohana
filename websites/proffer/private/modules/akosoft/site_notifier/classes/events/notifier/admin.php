<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Notifier_Admin extends Events {
	
	public function on_menu()
	{
		return View::factory('admin/notifier/menu');
	}
	
}
