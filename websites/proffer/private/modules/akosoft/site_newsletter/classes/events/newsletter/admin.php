<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Newsletter_Admin extends Events {
	
	public function on_menu()
	{
		return View::factory('admin/newsletter/menu');
	}

	public function on_index_index()
	{
		$count = ORM::factory('Newsletter_Queue')
				->count_all();

		return View::factory('admin/newsletter/index_box')
				->set('count', $count);
	}
}