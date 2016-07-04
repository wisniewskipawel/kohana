<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Widget_Posts_Sidebar_PFC extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$model_category = new Model_Post_Category();
		$categories = $model_category
			->filter_by_parent(NULL)
			->limit(3)
			->find_all();
		
		foreach($categories as $category)
		{
			$model = new Model_Post;
			$posts = $model->filter_by_approved()
				->filter_by_category($category)
				->limit(5)
				->get_list();
			
			if(count($posts) > 0)
			{
				$this->set('category', $category)
					->set('posts', $posts);
				
				return parent::render($view_file);
			}
		}
	}
	
}
