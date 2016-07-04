<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Template_Jobs extends Controller_Jobs {
	
	public function action_home()
	{
		$from = $this->request->query('from');
		$jobs = NULL;
		$jobs_promoted = NULL;
		$pagination = NULL;
		
		$model = new Model_Job;
		
		switch($from)
		{
			case 'popular':
				$model->filter_by_active();
				
				$pagination = Pagination::factory(array(
					'items_per_page' => 10,
					'total_items' => $model->reset(FALSE)->count_all(),
				));
				
				$model->with_count_replies()
					->apply_ordering('visits', 'DESC');
				
				$jobs = $model->set_pagination($pagination)->find_all();
				break;
			
			case 'promoted':
				$jobs = $model->find_promoted_home(10);
				break;
			
			case 'recent':
				$jobs = $model->find_recent_home(10);
				break;
			
			default:
				$from = 'recent';
				$jobs_promoted = $model->find_promoted_home(Jobs::config('home_promoted_box_limit'));
				$jobs = $model->find_recent_home(Jobs::config('home_recent_box_limit'));
				break;
		}
		
		breadcrumbs::add($this->_breadcrumb());
		
		$this->template->layout_data['frontend_main_index_top'] = Jobs::config('home_info_box');
		$this->template->content = View::factory('jobs/frontend/home')
			->set('jobs_promoted', $jobs_promoted)
			->set('from', $from)
			->set('jobs', $jobs);
	}
	
}
