<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Events_Jobs_Profile extends Events {

	public function on_nav()
	{
		switch($this->param('action'))
		{
			case 'closet':
				$current_user = Register::get('current_user');

				if($this->param('closet_counter') AND $current_user)
				{
					$title = ___('jobs.closet.tab', array(
						':nb' => Model_Job_Closet::count_by_user($current_user),
					));
				}
				else
				{
					$title = ___('jobs.profile.closet.title');
				}

				return HTML::anchor(
					Route::get('site_jobs/profile/closet')->uri(), 
					$title, 
					array(
						'class' => ($this->_route_name == 'site_jobs/profile/closet') ? 'active' : NULL,
					)
				);

			case 'my':
				$current_user = Register::get('current_user');

				$model = new Model_Job;
				$model->filter_by_user($current_user);
				$count_jobs = $model->count_all();

				$model->filter_by_user($current_user);
				$model->filter_by_active();
				$count_active_jobs = $model->count_all();

				return View::factory('jobs/profile/nav')
					->set('count_jobs', $count_jobs)
					->set('count_active_jobs', $count_active_jobs);
		}
	}

}
