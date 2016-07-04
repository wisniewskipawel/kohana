<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Users_Admin extends Events {
	
	public function on_menu()
	{
		return View::factory('admin/users/menu');
	}
	
	public function on_index()
	{
		$users_normal_count = ORM::factory('User')
			->where('user_id', 'NOT IN', DB::expr('
				(
					SELECT
						users.user_id
					FROM
						users
					JOIN
						users_to_groups
					ON
						users.user_id = users_to_groups.user_id
				)
			'))
			->count_all();

		$users_not_active_count = ORM::factory('User')
			->where('user_status', '=', Model_User::STATUS_NOT_ACTIVE)
			->count_all();

		$users_count = ORM::factory('User')->count_all();
		
		return View::factory('component/users/admin/index')
				->set('users_normal_count', $users_normal_count)
				->set('users_not_active_count', $users_not_active_count)
				->set('users_count', $users_count);
	}
	
}